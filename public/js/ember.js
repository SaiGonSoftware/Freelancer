;(function() {
/*!
 * @overview  Ember - JavaScript Application Framework
 * @copyright Copyright 2011-2015 Tilde Inc. and contributors
 *            Portions Copyright 2006-2011 Strobe Inc.
 *            Portions Copyright 2008-2011 Apple Inc. All rights reserved.
 * @license   Licensed under MIT license
 *            See https://raw.github.com/emberjs/ember.js/master/LICENSE
 * @version   2.3.1
 */

var enifed, requireModule, require, requirejs, Ember;
var mainContext = this;

(function() {
  var isNode = typeof window === 'undefined' &&
    typeof process !== 'undefined' && {}.toString.call(process) === '[object process]';

  if (!isNode) {
    Ember = this.Ember = this.Ember || {};
  }

  if (typeof Ember === 'undefined') { Ember = {}; };

  if (typeof Ember.__loader === 'undefined') {
    var registry = {};
    var seen = {};

    enifed = function(name, deps, callback) {
      var value = { };

      if (!callback) {
        value.deps = [];
        value.callback = deps;
      } else {
        value.deps = deps;
        value.callback = callback;
      }

      registry[name] = value;
    };

    requirejs = require = requireModule = function(name) {
      return internalRequire(name, null);
    }
    require['default'] = require;

    function missingModule(name, referrerName) {
      if (referrerName) {
        throw new Error('Could not find module ' + name + ' required by: ' + referrerName);
      } else {
        throw new Error('Could not find module ' + name);
      }
    }

    function internalRequire(name, referrerName) {
      var exports = seen[name];

      if (exports !== undefined) {
        return exports;
      }

      exports = seen[name] = {};

      if (!registry[name]) {
        missingModule(name, referrerName);
      }

      var mod = registry[name];
      var deps = mod.deps;
      var callback = mod.callback;
      var length = deps.length;
      var reified = new Array(length);;

      for (var i = 0; i < length; i++) {
        if (deps[i] === 'exports') {
          reified[i] = exports;
        } else if (deps[i] === 'require') {
          reified[i] = require;
        } else {
          reified[i] = internalRequire(deps[i], name);
        }
      }

      callback.apply(this, reified);

      return exports;
    };

    requirejs._eak_seen = registry;

    Ember.__loader = {
      define: enifed,
      require: require,
      registry: registry
    };
  } else {
    enifed = Ember.__loader.define;
    requirejs = require = requireModule = Ember.__loader.require;
  }
})();

enifed("backburner/binary-search", ["exports"], function (exports) {
  "use strict";

  exports.default = binarySearch;

  function binarySearch(time, timers) {
    var start = 0;
    var end = timers.length - 2;
    var middle, l;

    while (start < end) {
      // since timers is an array of pairs 'l' will always
      // be an integer
      l = (end - start) / 2;

      // compensate for the index in case even number
      // of pairs inside timers
      middle = start + l - l % 2;

      if (time >= timers[middle]) {
        start = middle + 2;
      } else {
        end = middle;
      }
    }

    return time >= timers[start] ? start + 2 : start;
  }
});
enifed('backburner/deferred-action-queues', ['exports', 'backburner/utils', 'backburner/queue'], function (exports, _backburnerUtils, _backburnerQueue) {
  'use strict';

  exports.default = DeferredActionQueues;

  function DeferredActionQueues(queueNames, options) {
    var queues = this.queues = {};
    this.queueNames = queueNames = queueNames || [];

    this.options = options;

    _backburnerUtils.each(queueNames, function (queueName) {
      queues[queueName] = new _backburnerQueue.default(queueName, options[queueName], options);
    });
  }

  function noSuchQueue(name) {
    throw new Error('You attempted to schedule an action in a queue (' + name + ') that doesn\'t exist');
  }

  function noSuchMethod(name) {
    throw new Error('You attempted to schedule an action in a queue (' + name + ') for a method that doesn\'t exist');
  }

  DeferredActionQueues.prototype = {
    schedule: function (name, target, method, args, onceFlag, stack) {
      var queues = this.queues;
      var queue = queues[name];

      if (!queue) {
        noSuchQueue(name);
      }

      if (!method) {
        noSuchMethod(name);
      }

      if (onceFlag) {
        return queue.pushUnique(target, method, args, stack);
      } else {
        return queue.push(target, method, args, stack);
      }
    },

    flush: function () {
      var queues = this.queues;
      var queueNames = this.queueNames;
      var queueName, queue;
      var queueNameIndex = 0;
      var numberOfQueues = queueNames.length;

      while (queueNameIndex < numberOfQueues) {
        queueName = queueNames[queueNameIndex];
        queue = queues[queueName];

        var numberOfQueueItems = queue._queue.length;

        if (numberOfQueueItems === 0) {
          queueNameIndex++;
        } else {
          queue.flush(false /* async */);
          queueNameIndex = 0;
        }
      }
    }
  };
});
enifed('backburner/platform', ['exports'], function (exports) {
  // In IE 6-8, try/finally doesn't work without a catch.
  // Unfortunately, this is impossible to test for since wrapping it in a parent try/catch doesn't trigger the bug.
  // This tests for another broken try/catch behavior that only exhibits in the same versions of IE.
  'use strict';

  var needsIETryCatchFix = (function (e, x) {
    try {
      x();
    } catch (e) {} // jshint ignore:line
    return !!e;
  })();

  exports.needsIETryCatchFix = needsIETryCatchFix;
  var platform;

  /* global self */
  if (typeof self === 'object') {
    platform = self;

    /* global global */
  } else if (typeof global === 'object') {
      platform = global;
    } else {
      throw new Error('no global: `self` or `global` found');
    }

  exports.default = platform;
});
enifed('backburner/queue', ['exports', 'backburner/utils'], function (exports, _backburnerUtils) {
  'use strict';

  exports.default = Queue;

  function Queue(name, options, globalOptions) {
    this.name = name;
    this.globalOptions = globalOptions || {};
    this.options = options;
    this._queue = [];
    this.targetQueues = {};
    this._queueBeingFlushed = undefined;
  }

  Queue.prototype = {
    push: function (target, method, args, stack) {
      var queue = this._queue;
      queue.push(target, method, args, stack);

      return {
        queue: this,
        target: target,
        method: method
      };
    },

    pushUniqueWithoutGuid: function (target, method, args, stack) {
      var queue = this._queue;

      for (var i = 0, l = queue.length; i < l; i += 4) {
        var currentTarget = queue[i];
        var currentMethod = queue[i + 1];

        if (currentTarget === target && currentMethod === method) {
          queue[i + 2] = args; // replace args
          queue[i + 3] = stack; // replace stack
          return;
        }
      }

      queue.push(target, method, args, stack);
    },

    targetQueue: function (targetQueue, target, method, args, stack) {
      var queue = this._queue;

      for (var i = 0, l = targetQueue.length; i < l; i += 2) {
        var currentMethod = targetQueue[i];
        var currentIndex = targetQueue[i + 1];

        if (currentMethod === method) {
          queue[currentIndex + 2] = args; // replace args
          queue[currentIndex + 3] = stack; // replace stack
          return;
        }
      }

      targetQueue.push(method, queue.push(target, method, args, stack) - 4);
    },

    pushUniqueWithGuid: function (guid, target, method, args, stack) {
      var hasLocalQueue = this.targetQueues[guid];

      if (hasLocalQueue) {
        this.targetQueue(hasLocalQueue, target, method, args, stack);
      } else {
        this.targetQueues[guid] = [method, this._queue.push(target, method, args, stack) - 4];
      }

      return {
        queue: this,
        target: target,
        method: method
      };
    },

    pushUnique: function (target, method, args, stack) {
      var KEY = this.globalOptions.GUID_KEY;

      if (target && KEY) {
        var guid = target[KEY];
        if (guid) {
          return this.pushUniqueWithGuid(guid, target, method, args, stack);
        }
      }

      this.pushUniqueWithoutGuid(target, method, args, stack);

      return {
        queue: this,
        target: target,
        method: method
      };
    },

    invoke: function (target, method, args, _, _errorRecordedForStack) {
      if (args && args.length > 0) {
        method.apply(target, args);
      } else {
        method.call(target);
      }
    },

    invokeWithOnError: function (target, method, args, onError, errorRecordedForStack) {
      try {
        if (args && args.length > 0) {
          method.apply(target, args);
        } else {
          method.call(target);
        }
      } catch (error) {
        onError(error, errorRecordedForStack);
      }
    },

    flush: function (sync) {
      var queue = this._queue;
      var length = queue.length;

      if (length === 0) {
        return;
      }

      var globalOptions = this.globalOptions;
      var options = this.options;
      var before = options && options.before;
      var after = options && options.after;
      var onError = globalOptions.onError || globalOptions.onErrorTarget && globalOptions.onErrorTarget[globalOptions.onErrorMethod];
      var target, method, args, errorRecordedForStack;
      var invoke = onError ? this.invokeWithOnError : this.invoke;

      this.targetQueues = Object.create(null);
      var queueItems = this._queueBeingFlushed = this._queue.slice();
      this._queue = [];

      if (before) {
        before();
      }

      for (var i = 0; i < length; i += 4) {
        target = queueItems[i];
        method = queueItems[i + 1];
        args = queueItems[i + 2];
        errorRecordedForStack = queueItems[i + 3]; // Debugging assistance

        if (_backburnerUtils.isString(method)) {
          method = target[method];
        }

        // method could have been nullified / canceled during flush
        if (method) {
          //
          //    ** Attention intrepid developer **
          //
          //    To find out the stack of this task when it was scheduled onto
          //    the run loop, add the following to your app.js:
          //
          //    Ember.run.backburner.DEBUG = true; // NOTE: This slows your app, don't leave it on in production.
          //
          //    Once that is in place, when you are at a breakpoint and navigate
          //    here in the stack explorer, you can look at `errorRecordedForStack.stack`,
          //    which will be the captured stack when this job was scheduled.
          //
          invoke(target, method, args, onError, errorRecordedForStack);
        }
      }

      if (after) {
        after();
      }

      this._queueBeingFlushed = undefined;

      if (sync !== false && this._queue.length > 0) {
        // check if new items have been added
        this.flush(true);
      }
    },

    cancel: function (actionToCancel) {
      var queue = this._queue,
          currentTarget,
          currentMethod,
          i,
          l;
      var target = actionToCancel.target;
      var method = actionToCancel.method;
      var GUID_KEY = this.globalOptions.GUID_KEY;

      if (GUID_KEY && this.targetQueues && target) {
        var targetQueue = this.targetQueues[target[GUID_KEY]];

        if (targetQueue) {
          for (i = 0, l = targetQueue.length; i < l; i++) {
            if (targetQueue[i] === method) {
              targetQueue.splice(i, 1);
            }
          }
        }
      }

      for (i = 0, l = queue.length; i < l; i += 4) {
        currentTarget = queue[i];
        currentMethod = queue[i + 1];

        if (currentTarget === target && currentMethod === method) {
          queue.splice(i, 4);
          return true;
        }
      }

      // if not found in current queue
      // could be in the queue that is being flushed
      queue = this._queueBeingFlushed;

      if (!queue) {
        return;
      }

      for (i = 0, l = queue.length; i < l; i += 4) {
        currentTarget = queue[i];
        currentMethod = queue[i + 1];

        if (currentTarget === target && currentMethod === method) {
          // don't mess with array during flush
          // just nullify the method
          queue[i + 1] = null;
          return true;
        }
      }
    }
  };
});
enifed('backburner/utils', ['exports'], function (exports) {
  'use strict';

  exports.each = each;
  exports.isString = isString;
  exports.isFunction = isFunction;
  exports.isNumber = isNumber;
  exports.isCoercableNumber = isCoercableNumber;
  exports.wrapInTryCatch = wrapInTryCatch;
  var NUMBER = /\d+/;

  function each(collection, callback) {
    for (var i = 0; i < collection.length; i++) {
      callback(collection[i]);
    }
  }

  // Date.now is not available in browsers < IE9
  // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date/now#Compatibility
  var now = Date.now || function () {
    return new Date().getTime();
  };

  exports.now = now;

  function isString(suspect) {
    return typeof suspect === 'string';
  }

  function isFunction(suspect) {
    return typeof suspect === 'function';
  }

  function isNumber(suspect) {
    return typeof suspect === 'number';
  }

  function isCoercableNumber(number) {
    return isNumber(number) || NUMBER.test(number);
  }

  function wrapInTryCatch(func) {
    return function () {
      try {
        return func.apply(this, arguments);
      } catch (e) {
        throw e;
      }
    };
  }
});
enifed('backburner', ['exports', 'backburner/utils', 'backburner/platform', 'backburner/binary-search', 'backburner/deferred-action-queues'], function (exports, _backburnerUtils, _backburnerPlatform, _backburnerBinarySearch, _backburnerDeferredActionQueues) {
  'use strict';

  exports.default = Backburner;

  function Backburner(queueNames, options) {
    this.queueNames = queueNames;
    this.options = options || {};
    if (!this.options.defaultQueue) {
      this.options.defaultQueue = queueNames[0];
    }
    this.instanceStack = [];
    this._debouncees = [];
    this._throttlers = [];
    this._eventCallbacks = {
      end: [],
      begin: []
    };

    this._timerTimeoutId = undefined;
    this._timers = [];

    var _this = this;
    this._boundRunExpiredTimers = function () {
      _this._runExpiredTimers();
    };
  }

  // ms of delay before we conclude a timeout was lost
  var TIMEOUT_STALLED_THRESHOLD = 1000;

  Backburner.prototype = {
    begin: function () {
      var options = this.options;
      var onBegin = options && options.onBegin;
      var previousInstance = this.currentInstance;

      if (previousInstance) {
        this.instanceStack.push(previousInstance);
      }

      this.currentInstance = new _backburnerDeferredActionQueues.default(this.queueNames, options);
      this._trigger('begin', this.currentInstance, previousInstance);
      if (onBegin) {
        onBegin(this.currentInstance, previousInstance);
      }
    },

    end: function () {
      var options = this.options;
      var onEnd = options && options.onEnd;
      var currentInstance = this.currentInstance;
      var nextInstance = null;

      // Prevent double-finally bug in Safari 6.0.2 and iOS 6
      // This bug appears to be resolved in Safari 6.0.5 and iOS 7
      var finallyAlreadyCalled = false;
      try {
        currentInstance.flush();
      } finally {
        if (!finallyAlreadyCalled) {
          finallyAlreadyCalled = true;

          this.currentInstance = null;

          if (this.instanceStack.length) {
            nextInstance = this.instanceStack.pop();
            this.currentInstance = nextInstance;
          }
          this._trigger('end', currentInstance, nextInstance);
          if (onEnd) {
            onEnd(currentInstance, nextInstance);
          }
        }
      }
    },

    /**
     Trigger an event. Supports up to two arguments. Designed around
     triggering transition events from one run loop instance to the
     next, which requires an argument for the first instance and then
     an argument for the next instance.
      @private
     @method _trigger
     @param {String} eventName
     @param {any} arg1
     @param {any} arg2
     */
    _trigger: function (eventName, arg1, arg2) {
      var callbacks = this._eventCallbacks[eventName];
      if (callbacks) {
        for (var i = 0; i < callbacks.length; i++) {
          callbacks[i](arg1, arg2);
        }
      }
    },

    on: function (eventName, callback) {
      if (typeof callback !== 'function') {
        throw new TypeError('Callback must be a function');
      }
      var callbacks = this._eventCallbacks[eventName];
      if (callbacks) {
        callbacks.push(callback);
      } else {
        throw new TypeError('Cannot on() event "' + eventName + '" because it does not exist');
      }
    },

    off: function (eventName, callback) {
      if (eventName) {
        var callbacks = this._eventCallbacks[eventName];
        var callbackFound = false;
        if (!callbacks) return;
        if (callback) {
          for (var i = 0; i < callbacks.length; i++) {
            if (callbacks[i] === callback) {
              callbackFound = true;
              callbacks.splice(i, 1);
              i--;
            }
          }
        }
        if (!callbackFound) {
          throw new TypeError('Cannot off() callback that does not exist');
        }
      } else {
        throw new TypeError('Cannot off() event "' + eventName + '" because it does not exist');
      }
    },

    run: function () /* target, method, args */{
      var length = arguments.length;
      var method, target, args;

      if (length === 1) {
        method = arguments[0];
        target = null;
      } else {
        target = arguments[0];
        method = arguments[1];
      }

      if (_backburnerUtils.isString(method)) {
        method = target[method];
      }

      if (length > 2) {
        args = new Array(length - 2);
        for (var i = 0, l = length - 2; i < l; i++) {
          args[i] = arguments[i + 2];
        }
      } else {
        args = [];
      }

      var onError = getOnError(this.options);

      this.begin();

      // guard against Safari 6's double-finally bug
      var didFinally = false;

      if (onError) {
        try {
          return method.apply(target, args);
        } catch (error) {
          onError(error);
        } finally {
          if (!didFinally) {
            didFinally = true;
            this.end();
          }
        }
      } else {
        try {
          return method.apply(target, args);
        } finally {
          if (!didFinally) {
            didFinally = true;
            this.end();
          }
        }
      }
    },

    /*
      Join the passed method with an existing queue and execute immediately,
      if there isn't one use `Backburner#run`.
        The join method is like the run method except that it will schedule into
      an existing queue if one already exists. In either case, the join method will
      immediately execute the passed in function and return its result.
       @method join 
      @param {Object} target
      @param {Function} method The method to be executed 
      @param {any} args The method arguments
      @return method result
    */
    join: function () /* target, method, args */{
      if (!this.currentInstance) {
        return this.run.apply(this, arguments);
      }

      var length = arguments.length;
      var method, target;

      if (length === 1) {
        method = arguments[0];
        target = null;
      } else {
        target = arguments[0];
        method = arguments[1];
      }

      if (_backburnerUtils.isString(method)) {
        method = target[method];
      }

      if (length === 1) {
        return method();
      } else if (length === 2) {
        return method.call(target);
      } else {
        var args = new Array(length - 2);
        for (var i = 0, l = length - 2; i < l; i++) {
          args[i] = arguments[i + 2];
        }
        return method.apply(target, args);
      }
    },

    /*
      Defer the passed function to run inside the specified queue.
       @method defer 
      @param {String} queueName 
      @param {Object} target
      @param {Function|String} method The method or method name to be executed 
      @param {any} args The method arguments
      @return method result
    */
    defer: function (queueName /* , target, method, args */) {
      var length = arguments.length;
      var method, target, args;

      if (length === 2) {
        method = arguments[1];
        target = null;
      } else {
        target = arguments[1];
        method = arguments[2];
      }

      if (_backburnerUtils.isString(method)) {
        method = target[method];
      }

      var stack = this.DEBUG ? new Error() : undefined;

      if (length > 3) {
        args = new Array(length - 3);
        for (var i = 3; i < length; i++) {
          args[i - 3] = arguments[i];
        }
      } else {
        args = undefined;
      }

      if (!this.currentInstance) {
        createAutorun(this);
      }
      return this.currentInstance.schedule(queueName, target, method, args, false, stack);
    },

    deferOnce: function (queueName /* , target, method, args */) {
      var length = arguments.length;
      var method, target, args;

      if (length === 2) {
        method = arguments[1];
        target = null;
      } else {
        target = arguments[1];
        method = arguments[2];
      }

      if (_backburnerUtils.isString(method)) {
        method = target[method];
      }

      var stack = this.DEBUG ? new Error() : undefined;

      if (length > 3) {
        args = new Array(length - 3);
        for (var i = 3; i < length; i++) {
          args[i - 3] = arguments[i];
        }
      } else {
        args = undefined;
      }

      if (!this.currentInstance) {
        createAutorun(this);
      }
      return this.currentInstance.schedule(queueName, target, method, args, true, stack);
    },

    setTimeout: function () {
      var l = arguments.length;
      var args = new Array(l);

      for (var x = 0; x < l; x++) {
        args[x] = arguments[x];
      }

      var length = args.length,
          method,
          wait,
          target,
          methodOrTarget,
          methodOrWait,
          methodOrArgs;

      if (length === 0) {
        return;
      } else if (length === 1) {
        method = args.shift();
        wait = 0;
      } else if (length === 2) {
        methodOrTarget = args[0];
        methodOrWait = args[1];

        if (_backburnerUtils.isFunction(methodOrWait) || _backburnerUtils.isFunction(methodOrTarget[methodOrWait])) {
          target = args.shift();
          method = args.shift();
          wait = 0;
        } else if (_backburnerUtils.isCoercableNumber(methodOrWait)) {
          method = args.shift();
          wait = args.shift();
        } else {
          method = args.shift();
          wait = 0;
        }
      } else {
        var last = args[args.length - 1];

        if (_backburnerUtils.isCoercableNumber(last)) {
          wait = args.pop();
        } else {
          wait = 0;
        }

        methodOrTarget = args[0];
        methodOrArgs = args[1];

        if (_backburnerUtils.isFunction(methodOrArgs) || _backburnerUtils.isString(methodOrArgs) && methodOrTarget !== null && methodOrArgs in methodOrTarget) {
          target = args.shift();
          method = args.shift();
        } else {
          method = args.shift();
        }
      }

      var executeAt = _backburnerUtils.now() + parseInt(wait, 10);

      if (_backburnerUtils.isString(method)) {
        method = target[method];
      }

      var onError = getOnError(this.options);

      function fn() {
        if (onError) {
          try {
            method.apply(target, args);
          } catch (e) {
            onError(e);
          }
        } else {
          method.apply(target, args);
        }
      }

      return this._setTimeout(fn, executeAt);
    },

    _setTimeout: function (fn, executeAt) {
      if (this._timers.length === 0) {
        this._timers.push(executeAt, fn);
        this._installTimerTimeout();
        return fn;
      }

      this._reinstallStalledTimerTimeout();

      // find position to insert
      var i = _backburnerBinarySearch.default(executeAt, this._timers);

      this._timers.splice(i, 0, executeAt, fn);

      // we should be the new earliest timer if i == 0
      if (i === 0) {
        this._reinstallTimerTimeout();
      }

      return fn;
    },

    throttle: function (target, method /* , args, wait, [immediate] */) {
      var backburner = this;
      var args = new Array(arguments.length);
      for (var i = 0; i < arguments.length; i++) {
        args[i] = arguments[i];
      }
      var immediate = args.pop();
      var wait, throttler, index, timer;

      if (_backburnerUtils.isNumber(immediate) || _backburnerUtils.isString(immediate)) {
        wait = immediate;
        immediate = true;
      } else {
        wait = args.pop();
      }

      wait = parseInt(wait, 10);

      index = findThrottler(target, method, this._throttlers);
      if (index > -1) {
        return this._throttlers[index];
      } // throttled

      timer = _backburnerPlatform.default.setTimeout(function () {
        if (!immediate) {
          backburner.run.apply(backburner, args);
        }
        var index = findThrottler(target, method, backburner._throttlers);
        if (index > -1) {
          backburner._throttlers.splice(index, 1);
        }
      }, wait);

      if (immediate) {
        this.run.apply(this, args);
      }

      throttler = [target, method, timer];

      this._throttlers.push(throttler);

      return throttler;
    },

    debounce: function (target, method /* , args, wait, [immediate] */) {
      var backburner = this;
      var args = new Array(arguments.length);
      for (var i = 0; i < arguments.length; i++) {
        args[i] = arguments[i];
      }

      var immediate = args.pop();
      var wait, index, debouncee, timer;

      if (_backburnerUtils.isNumber(immediate) || _backburnerUtils.isString(immediate)) {
        wait = immediate;
        immediate = false;
      } else {
        wait = args.pop();
      }

      wait = parseInt(wait, 10);
      // Remove debouncee
      index = findDebouncee(target, method, this._debouncees);

      if (index > -1) {
        debouncee = this._debouncees[index];
        this._debouncees.splice(index, 1);
        clearTimeout(debouncee[2]);
      }

      timer = _backburnerPlatform.default.setTimeout(function () {
        if (!immediate) {
          backburner.run.apply(backburner, args);
        }
        var index = findDebouncee(target, method, backburner._debouncees);
        if (index > -1) {
          backburner._debouncees.splice(index, 1);
        }
      }, wait);

      if (immediate && index === -1) {
        backburner.run.apply(backburner, args);
      }

      debouncee = [target, method, timer];

      backburner._debouncees.push(debouncee);

      return debouncee;
    },

    cancelTimers: function () {
      _backburnerUtils.each(this._throttlers, clearItems);
      this._throttlers = [];

      _backburnerUtils.each(this._debouncees, clearItems);
      this._debouncees = [];

      this._clearTimerTimeout();
      this._timers = [];

      if (this._autorun) {
        clearTimeout(this._autorun);
        this._autorun = null;
      }
    },

    hasTimers: function () {
      return !!this._timers.length || !!this._debouncees.length || !!this._throttlers.length || this._autorun;
    },

    cancel: function (timer) {
      var timerType = typeof timer;

      if (timer && timerType === 'object' && timer.queue && timer.method) {
        // we're cancelling a deferOnce
        return timer.queue.cancel(timer);
      } else if (timerType === 'function') {
        // we're cancelling a setTimeout
        for (var i = 0, l = this._timers.length; i < l; i += 2) {
          if (this._timers[i + 1] === timer) {
            this._timers.splice(i, 2); // remove the two elements
            if (i === 0) {
              this._reinstallTimerTimeout();
            }
            return true;
          }
        }
      } else if (Object.prototype.toString.call(timer) === '[object Array]') {
        // we're cancelling a throttle or debounce
        return this._cancelItem(findThrottler, this._throttlers, timer) || this._cancelItem(findDebouncee, this._debouncees, timer);
      } else {
        return; // timer was null or not a timer
      }
    },

    _cancelItem: function (findMethod, array, timer) {
      var item, index;

      if (timer.length < 3) {
        return false;
      }

      index = findMethod(timer[0], timer[1], array);

      if (index > -1) {

        item = array[index];

        if (item[2] === timer[2]) {
          array.splice(index, 1);
          clearTimeout(timer[2]);
          return true;
        }
      }

      return false;
    },

    _runExpiredTimers: function () {
      this._timerTimeoutId = undefined;
      this.run(this, this._scheduleExpiredTimers);
    },

    _scheduleExpiredTimers: function () {
      var n = _backburnerUtils.now();
      var timers = this._timers;
      var i = 0;
      var l = timers.length;
      for (; i < l; i += 2) {
        var executeAt = timers[i];
        var fn = timers[i + 1];
        if (executeAt <= n) {
          this.schedule(this.options.defaultQueue, null, fn);
        } else {
          break;
        }
      }
      timers.splice(0, i);
      this._installTimerTimeout();
    },

    _reinstallStalledTimerTimeout: function () {
      if (!this._timerTimeoutId) {
        return;
      }
      // if we have a timer we should always have a this._timerTimeoutId
      var minExpiresAt = this._timers[0];
      var delay = _backburnerUtils.now() - minExpiresAt;
      // threshold of a second before we assume that the currently
      // installed timeout will not run, so we don't constantly reinstall
      // timeouts that are delayed but good still
      if (delay < TIMEOUT_STALLED_THRESHOLD) {
        return;
      }
    },

    _reinstallTimerTimeout: function () {
      this._clearTimerTimeout();
      this._installTimerTimeout();
    },

    _clearTimerTimeout: function () {
      if (!this._timerTimeoutId) {
        return;
      }
      clearTimeout(this._timerTimeoutId);
      this._timerTimeoutId = undefined;
    },

    _installTimerTimeout: function () {
      if (!this._timers.length) {
        return;
      }
      var minExpiresAt = this._timers[0];
      var n = _backburnerUtils.now();
      var wait = Math.max(0, minExpiresAt - n);
      this._timerTimeoutId = setTimeout(this._boundRunExpiredTimers, wait);
    }
  };

  Backburner.prototype.schedule = Backburner.prototype.defer;
  Backburner.prototype.scheduleOnce = Backburner.prototype.deferOnce;
  Backburner.prototype.later = Backburner.prototype.setTimeout;

  if (_backburnerPlatform.needsIETryCatchFix) {
    var originalRun = Backburner.prototype.run;
    Backburner.prototype.run = _backburnerUtils.wrapInTryCatch(originalRun);

    var originalEnd = Backburner.prototype.end;
    Backburner.prototype.end = _backburnerUtils.wrapInTryCatch(originalEnd);
  }

  function getOnError(options) {
    return options.onError || options.onErrorTarget && options.onErrorTarget[options.onErrorMethod];
  }

  function createAutorun(backburner) {
    backburner.begin();
    backburner._autorun = _backburnerPlatform.default.setTimeout(function () {
      backburner._autorun = null;
      backburner.end();
    });
  }

  function findDebouncee(target, method, debouncees) {
    return findItem(target, method, debouncees);
  }

  function findThrottler(target, method, throttlers) {
    return findItem(target, method, throttlers);
  }

  function findItem(target, method, collection) {
    var item;
    var index = -1;

    for (var i = 0, l = collection.length; i < l; i++) {
      item = collection[i];
      if (item[0] === target && item[1] === method) {
        index = i;
        break;
      }
    }

    return index;
  }

  function clearItems(item) {
    clearTimeout(item[2]);
  }
});
enifed('container/container', ['exports', 'ember-metal/core', 'ember-metal/debug', 'ember-metal/dictionary', 'ember-metal/features', 'container/owner', 'ember-runtime/mixins/container_proxy', 'ember-metal/symbol'], function (exports, _emberMetalCore, _emberMetalDebug, _emberMetalDictionary, _emberMetalFeatures, _containerOwner, _emberRuntimeMixinsContainer_proxy, _emberMetalSymbol) {
  'use strict';

  var CONTAINER_OVERRIDE = _emberMetalSymbol.default('CONTAINER_OVERRIDE');

  /**
   A container used to instantiate and cache objects.
  
   Every `Container` must be associated with a `Registry`, which is referenced
   to determine the factory and options that should be used to instantiate
   objects.
  
   The public API for `Container` is still in flux and should not be considered
   stable.
  
   @private
   @class Container
   */
  function Container(registry, options) {
    this.registry = registry;
    this.owner = options && options.owner ? options.owner : null;
    this.cache = _emberMetalDictionary.default(options && options.cache ? options.cache : null);
    this.factoryCache = _emberMetalDictionary.default(options && options.factoryCache ? options.factoryCache : null);
    this.validationCache = _emberMetalDictionary.default(options && options.validationCache ? options.validationCache : null);

    this._fakeContainerToInject = _emberRuntimeMixinsContainer_proxy.buildFakeContainerWithDeprecations(this);
    this[CONTAINER_OVERRIDE] = undefined;
  }

  Container.prototype = {
    /**
     @private
     @property owner
     @type Object
     */
    owner: null,

    /**
     @private
     @property registry
     @type Registry
     @since 1.11.0
     */
    registry: null,

    /**
     @private
     @property cache
     @type InheritingDict
     */
    cache: null,

    /**
     @private
     @property factoryCache
     @type InheritingDict
     */
    factoryCache: null,

    /**
     @private
     @property validationCache
     @type InheritingDict
     */
    validationCache: null,

    /**
     Given a fullName return a corresponding instance.
      The default behaviour is for lookup to return a singleton instance.
     The singleton is scoped to the container, allowing multiple containers
     to all have their own locally scoped singletons.
      ```javascript
     var registry = new Registry();
     var container = registry.container();
      registry.register('api:twitter', Twitter);
      var twitter = container.lookup('api:twitter');
      twitter instanceof Twitter; // => true
      // by default the container will return singletons
     var twitter2 = container.lookup('api:twitter');
     twitter2 instanceof Twitter; // => true
      twitter === twitter2; //=> true
     ```
      If singletons are not wanted an optional flag can be provided at lookup.
      ```javascript
     var registry = new Registry();
     var container = registry.container();
      registry.register('api:twitter', Twitter);
      var twitter = container.lookup('api:twitter', { singleton: false });
     var twitter2 = container.lookup('api:twitter', { singleton: false });
      twitter === twitter2; //=> false
     ```
      @private
     @method lookup
     @param {String} fullName
     @param {Object} options
     @return {any}
     */
    lookup: function (fullName, options) {
      _emberMetalDebug.assert('fullName must be a proper full name', this.registry.validateFullName(fullName));
      return lookup(this, this.registry.normalize(fullName), options);
    },

    /**
     Given a fullName return the corresponding factory.
      @private
     @method lookupFactory
     @param {String} fullName
     @return {any}
     */
    lookupFactory: function (fullName) {
      _emberMetalDebug.assert('fullName must be a proper full name', this.registry.validateFullName(fullName));
      return factoryFor(this, this.registry.normalize(fullName));
    },

    /**
     A depth first traversal, destroying the container, its descendant containers and all
     their managed objects.
      @private
     @method destroy
     */
    destroy: function () {
      eachDestroyable(this, function (item) {
        if (item.destroy) {
          item.destroy();
        }
      });

      this.isDestroyed = true;
    },

    /**
     Clear either the entire cache or just the cache for a particular key.
      @private
     @method reset
     @param {String} fullName optional key to reset; if missing, resets everything
     */
    reset: function (fullName) {
      if (arguments.length > 0) {
        resetMember(this, this.registry.normalize(fullName));
      } else {
        resetCache(this);
      }
    },

    /**
     Returns an object that can be used to provide an owner to a
     manually created instance.
      @private
     @method ownerInjection
     @returns { Object }
    */
    ownerInjection: function () {
      var _ref;

      return _ref = {}, _ref[_containerOwner.OWNER] = this.owner, _ref;
    }
  };

  function isSingleton(container, fullName) {
    return container.registry.getOption(fullName, 'singleton') !== false;
  }

  function lookup(container, fullName, options) {
    options = options || {};

    if (container.cache[fullName] && options.singleton !== false) {
      return container.cache[fullName];
    }

    var value = instantiate(container, fullName);

    if (value === undefined) {
      return;
    }

    if (isSingleton(container, fullName) && options.singleton !== false) {
      container.cache[fullName] = value;
    }

    return value;
  }

  function markInjectionsAsDynamic(injections) {
    injections._dynamic = true;
  }

  function areInjectionsDynamic(injections) {
    return !!injections._dynamic;
  }

  function buildInjections() /* container, ...injections */{
    var hash = {};

    if (arguments.length > 1) {
      var container = arguments[0];
      var injections = [];
      var injection;

      for (var i = 1, l = arguments.length; i < l; i++) {
        if (arguments[i]) {
          injections = injections.concat(arguments[i]);
        }
      }

      container.registry.validateInjections(injections);

      for (i = 0, l = injections.length; i < l; i++) {
        injection = injections[i];
        hash[injection.property] = lookup(container, injection.fullName);
        if (!isSingleton(container, injection.fullName)) {
          markInjectionsAsDynamic(hash);
        }
      }
    }

    return hash;
  }

  function factoryFor(container, fullName) {
    var cache = container.factoryCache;
    if (cache[fullName]) {
      return cache[fullName];
    }
    var registry = container.registry;
    var factory = registry.resolve(fullName);
    if (factory === undefined) {
      return;
    }

    var type = fullName.split(':')[0];
    if (!factory || typeof factory.extend !== 'function' || !_emberMetalCore.default.MODEL_FACTORY_INJECTIONS && type === 'model') {
      if (factory && typeof factory._onLookup === 'function') {
        factory._onLookup(fullName);
      }

      // TODO: think about a 'safe' merge style extension
      // for now just fallback to create time injection
      cache[fullName] = factory;
      return factory;
    } else {
      var injections = injectionsFor(container, fullName);
      var factoryInjections = factoryInjectionsFor(container, fullName);
      var cacheable = !areInjectionsDynamic(injections) && !areInjectionsDynamic(factoryInjections);

      factoryInjections._toString = registry.makeToString(factory, fullName);

      var injectedFactory = factory.extend(injections);

      // TODO - remove all `container` injections when Ember reaches v3.0.0

      injectDeprecatedContainer(injectedFactory.prototype, container);

      injectedFactory.reopenClass(factoryInjections);

      if (factory && typeof factory._onLookup === 'function') {
        factory._onLookup(fullName);
      }

      if (cacheable) {
        cache[fullName] = injectedFactory;
      }

      return injectedFactory;
    }
  }

  function injectionsFor(container, fullName) {
    var registry = container.registry;
    var splitName = fullName.split(':');
    var type = splitName[0];

    var injections = buildInjections(container, registry.getTypeInjections(type), registry.getInjections(fullName));
    injections._debugContainerKey = fullName;

    _containerOwner.setOwner(injections, container.owner);

    return injections;
  }

  function factoryInjectionsFor(container, fullName) {
    var registry = container.registry;
    var splitName = fullName.split(':');
    var type = splitName[0];

    var factoryInjections = buildInjections(container, registry.getFactoryTypeInjections(type), registry.getFactoryInjections(fullName));
    factoryInjections._debugContainerKey = fullName;

    return factoryInjections;
  }

  function instantiate(container, fullName) {
    var factory = factoryFor(container, fullName);
    var lazyInjections, validationCache;

    if (container.registry.getOption(fullName, 'instantiate') === false) {
      return factory;
    }

    if (factory) {
      if (typeof factory.create !== 'function') {
        throw new Error('Failed to create an instance of \'' + fullName + '\'. ' + 'Most likely an improperly defined class or an invalid module export.');
      }

      validationCache = container.validationCache;

      // Ensure that all lazy injections are valid at instantiation time
      if (!validationCache[fullName] && typeof factory._lazyInjections === 'function') {
        lazyInjections = factory._lazyInjections();
        lazyInjections = container.registry.normalizeInjectionsHash(lazyInjections);

        container.registry.validateInjections(lazyInjections);
      }

      validationCache[fullName] = true;

      var obj = undefined;

      if (typeof factory.extend === 'function') {
        // assume the factory was extendable and is already injected
        obj = factory.create();
      } else {
        // assume the factory was extendable
        // to create time injections
        // TODO: support new'ing for instantiation and merge injections for pure JS Functions
        var injections = injectionsFor(container, fullName);

        // Ensure that a container is available to an object during instantiation.
        // TODO - remove when Ember reaches v3.0.0

        // This "fake" container will be replaced after instantiation with a
        // property that raises deprecations every time it is accessed.
        injections.container = container._fakeContainerToInject;

        obj = factory.create(injections);

        // TODO - remove when Ember reaches v3.0.0

        if (!Object.isFrozen(obj) && 'container' in obj) {
          injectDeprecatedContainer(obj, container);
        }
      }

      return obj;
    }
  }

  // TODO - remove when Ember reaches v3.0.0
  function injectDeprecatedContainer(object, container) {
    Object.defineProperty(object, 'container', {
      configurable: true,
      enumerable: false,
      get: function () {
        _emberMetalDebug.deprecate('Using the injected `container` is deprecated. Please use the `getOwner` helper instead to access the owner of this object.', false, { id: 'ember-application.injected-container', until: '3.0.0', url: 'http://emberjs.com/deprecations/v2.x#toc_injected-container-access' });
        return this[CONTAINER_OVERRIDE] || container;
      },

      set: function (value) {
        _emberMetalDebug.deprecate('Providing the `container` property to ' + this + ' is deprecated. Please use `Ember.setOwner` or `owner.ownerInjection()` instead to provide an owner to the instance being created.', false, { id: 'ember-application.injected-container', until: '3.0.0', url: 'http://emberjs.com/deprecations/v2.x#toc_injected-container-access' });

        this[CONTAINER_OVERRIDE] = value;

        return value;
      }
    });
  }

  function eachDestroyable(container, callback) {
    var cache = container.cache;
    var keys = Object.keys(cache);
    var key, value;

    for (var i = 0, l = keys.length; i < l; i++) {
      key = keys[i];
      value = cache[key];

      if (container.registry.getOption(key, 'instantiate') !== false) {
        callback(value);
      }
    }
  }

  function resetCache(container) {
    eachDestroyable(container, function (value) {
      if (value.destroy) {
        value.destroy();
      }
    });

    container.cache.dict = _emberMetalDictionary.default(null);
  }

  function resetMember(container, fullName) {
    var member = container.cache[fullName];

    delete container.factoryCache[fullName];

    if (member) {
      delete container.cache[fullName];

      if (member.destroy) {
        member.destroy();
      }
    }
  }

  exports.default = Container;
});
enifed('container/owner', ['exports', 'ember-metal/symbol'], function (exports, _emberMetalSymbol) {
  /**
  @module ember
  @submodule ember-runtime
  */

  'use strict';

  exports.getOwner = getOwner;
  exports.setOwner = setOwner;
  var OWNER = _emberMetalSymbol.default('OWNER');

  exports.OWNER = OWNER;
  /**
    Framework objects in an Ember application (components, services, routes, etc.)
    are created via a factory and dependency injection system. Each of these
    objects is the responsibility of an "owner", which handled its
    instantiation and manages its lifetime.
  
    `getOwner` fetches the owner object responsible for an instance. This can
    be used to lookup or resolve other class instances, or register new factories
    into the owner.
  
    For example, this component dynamically looks up a service based on the
    `audioType` passed as an attribute:
  
    ```
    // app/components/play-audio.js
    import Ember from 'ember';
  
    // Usage:
    //
    //   {{play-audio audioType=model.audioType audioFile=model.file}}
    //
    export default Ember.Component.extend({
      audioService: Ember.computed('audioType', function() {
        let owner = Ember.getOwner(this);
        return owner.lookup(`service:${this.get('audioType')}`);
      }),
      click() {
        let player = this.get('audioService');
        player.play(this.get('audioFile'));
      }
    });
    ```
  
    @method getOwner
    @param {Object} object A object with an owner.
    @return {Object} an owner object.
    @for Ember
    @public
  */

  function getOwner(object) {
    return object[OWNER];
  }

  /**
    `setOwner` forces a new owner on a given object instance. This is primarily
    useful in some testing cases.
  
    @method setOwner
    @param {Object} object A object with an owner.
    @return {Object} an owner object.
    @for Ember
    @public
  */

  function setOwner(object, owner) {
    object[OWNER] = owner;
  }
});
enifed('container/registry', ['exports', 'ember-metal/debug', 'ember-metal/dictionary', 'ember-metal/assign', 'container/container'], function (exports, _emberMetalDebug, _emberMetalDictionary, _emberMetalAssign, _containerContainer) {
  'use strict';

  var VALID_FULL_NAME_REGEXP = /^[^:]+.+:[^:]+$/;

  /**
   A registry used to store factory and option information keyed
   by type.
  
   A `Registry` stores the factory and option information needed by a
   `Container` to instantiate and cache objects.
  
   The API for `Registry` is still in flux and should not be considered stable.
  
   @private
   @class Registry
   @since 1.11.0
  */
  function Registry(options) {
    this.fallback = options && options.fallback ? options.fallback : null;

    if (options && options.resolver) {
      this.resolver = options.resolver;

      if (typeof this.resolver === 'function') {
        deprecateResolverFunction(this);
      }
    }

    this.registrations = _emberMetalDictionary.default(options && options.registrations ? options.registrations : null);

    this._typeInjections = _emberMetalDictionary.default(null);
    this._injections = _emberMetalDictionary.default(null);
    this._factoryTypeInjections = _emberMetalDictionary.default(null);
    this._factoryInjections = _emberMetalDictionary.default(null);

    this._normalizeCache = _emberMetalDictionary.default(null);
    this._resolveCache = _emberMetalDictionary.default(null);
    this._failCache = _emberMetalDictionary.default(null);

    this._options = _emberMetalDictionary.default(null);
    this._typeOptions = _emberMetalDictionary.default(null);
  }

  Registry.prototype = {
    /**
     A backup registry for resolving registrations when no matches can be found.
      @private
     @property fallback
     @type Registry
     */
    fallback: null,

    /**
     An object that has a `resolve` method that resolves a name.
      @private
     @property resolver
     @type Resolver
     */
    resolver: null,

    /**
     @private
     @property registrations
     @type InheritingDict
     */
    registrations: null,

    /**
     @private
      @property _typeInjections
     @type InheritingDict
     */
    _typeInjections: null,

    /**
     @private
      @property _injections
     @type InheritingDict
     */
    _injections: null,

    /**
     @private
      @property _factoryTypeInjections
     @type InheritingDict
     */
    _factoryTypeInjections: null,

    /**
     @private
      @property _factoryInjections
     @type InheritingDict
     */
    _factoryInjections: null,

    /**
     @private
      @property _normalizeCache
     @type InheritingDict
     */
    _normalizeCache: null,

    /**
     @private
      @property _resolveCache
     @type InheritingDict
     */
    _resolveCache: null,

    /**
     @private
      @property _options
     @type InheritingDict
     */
    _options: null,

    /**
     @private
      @property _typeOptions
     @type InheritingDict
     */
    _typeOptions: null,

    /**
     Creates a container based on this registry.
      @private
     @method container
     @param {Object} options
     @return {Container} created container
     */
    container: function (options) {
      return new _containerContainer.default(this, options);
    },

    /**
     Registers a factory for later injection.
      Example:
      ```javascript
     var registry = new Registry();
      registry.register('model:user', Person, {singleton: false });
     registry.register('fruit:favorite', Orange);
     registry.register('communication:main', Email, {singleton: false});
     ```
      @private
     @method register
     @param {String} fullName
     @param {Function} factory
     @param {Object} options
     */
    register: function (fullName, factory, options) {
      _emberMetalDebug.assert('fullName must be a proper full name', this.validateFullName(fullName));

      if (factory === undefined) {
        throw new TypeError('Attempting to register an unknown factory: `' + fullName + '`');
      }

      var normalizedName = this.normalize(fullName);

      if (this._resolveCache[normalizedName]) {
        throw new Error('Cannot re-register: `' + fullName + '`, as it has already been resolved.');
      }

      delete this._failCache[normalizedName];
      this.registrations[normalizedName] = factory;
      this._options[normalizedName] = options || {};
    },

    /**
     Unregister a fullName
      ```javascript
     var registry = new Registry();
     registry.register('model:user', User);
      registry.resolve('model:user').create() instanceof User //=> true
      registry.unregister('model:user')
     registry.resolve('model:user') === undefined //=> true
     ```
      @private
     @method unregister
     @param {String} fullName
     */
    unregister: function (fullName) {
      _emberMetalDebug.assert('fullName must be a proper full name', this.validateFullName(fullName));

      var normalizedName = this.normalize(fullName);

      delete this.registrations[normalizedName];
      delete this._resolveCache[normalizedName];
      delete this._failCache[normalizedName];
      delete this._options[normalizedName];
    },

    /**
     Given a fullName return the corresponding factory.
      By default `resolve` will retrieve the factory from
     the registry.
      ```javascript
     var registry = new Registry();
     registry.register('api:twitter', Twitter);
      registry.resolve('api:twitter') // => Twitter
     ```
      Optionally the registry can be provided with a custom resolver.
     If provided, `resolve` will first provide the custom resolver
     the opportunity to resolve the fullName, otherwise it will fallback
     to the registry.
      ```javascript
     var registry = new Registry();
     registry.resolver = function(fullName) {
        // lookup via the module system of choice
      };
      // the twitter factory is added to the module system
     registry.resolve('api:twitter') // => Twitter
     ```
      @private
     @method resolve
     @param {String} fullName
     @return {Function} fullName's factory
     */
    resolve: function (fullName) {
      _emberMetalDebug.assert('fullName must be a proper full name', this.validateFullName(fullName));
      var factory = resolve(this, this.normalize(fullName));
      if (factory === undefined && this.fallback) {
        factory = this.fallback.resolve(fullName);
      }
      return factory;
    },

    /**
     A hook that can be used to describe how the resolver will
     attempt to find the factory.
      For example, the default Ember `.describe` returns the full
     class name (including namespace) where Ember's resolver expects
     to find the `fullName`.
      @private
     @method describe
     @param {String} fullName
     @return {string} described fullName
     */
    describe: function (fullName) {
      if (this.resolver && this.resolver.lookupDescription) {
        return this.resolver.lookupDescription(fullName);
      } else if (this.fallback) {
        return this.fallback.describe(fullName);
      } else {
        return fullName;
      }
    },

    /**
     A hook to enable custom fullName normalization behaviour
      @private
     @method normalizeFullName
     @param {String} fullName
     @return {string} normalized fullName
     */
    normalizeFullName: function (fullName) {
      if (this.resolver && this.resolver.normalize) {
        return this.resolver.normalize(fullName);
      } else if (this.fallback) {
        return this.fallback.normalizeFullName(fullName);
      } else {
        return fullName;
      }
    },

    /**
     Normalize a fullName based on the application's conventions
      @private
     @method normalize
     @param {String} fullName
     @return {string} normalized fullName
     */
    normalize: function (fullName) {
      return this._normalizeCache[fullName] || (this._normalizeCache[fullName] = this.normalizeFullName(fullName));
    },

    /**
     @method makeToString
      @private
     @param {any} factory
     @param {string} fullName
     @return {function} toString function
     */
    makeToString: function (factory, fullName) {
      if (this.resolver && this.resolver.makeToString) {
        return this.resolver.makeToString(factory, fullName);
      } else if (this.fallback) {
        return this.fallback.makeToString(factory, fullName);
      } else {
        return factory.toString();
      }
    },

    /**
     Given a fullName check if the container is aware of its factory
     or singleton instance.
      @private
     @method has
     @param {String} fullName
     @return {Boolean}
     */
    has: function (fullName) {
      _emberMetalDebug.assert('fullName must be a proper full name', this.validateFullName(fullName));
      return has(this, this.normalize(fullName));
    },

    /**
     Allow registering options for all factories of a type.
      ```javascript
     var registry = new Registry();
     var container = registry.container();
      // if all of type `connection` must not be singletons
     registry.optionsForType('connection', { singleton: false });
      registry.register('connection:twitter', TwitterConnection);
     registry.register('connection:facebook', FacebookConnection);
      var twitter = container.lookup('connection:twitter');
     var twitter2 = container.lookup('connection:twitter');
      twitter === twitter2; // => false
      var facebook = container.lookup('connection:facebook');
     var facebook2 = container.lookup('connection:facebook');
      facebook === facebook2; // => false
     ```
      @private
     @method optionsForType
     @param {String} type
     @param {Object} options
     */
    optionsForType: function (type, options) {
      this._typeOptions[type] = options;
    },

    getOptionsForType: function (type) {
      var optionsForType = this._typeOptions[type];
      if (optionsForType === undefined && this.fallback) {
        optionsForType = this.fallback.getOptionsForType(type);
      }
      return optionsForType;
    },

    /**
     @private
     @method options
     @param {String} fullName
     @param {Object} options
     */
    options: function (fullName, options) {
      options = options || {};
      var normalizedName = this.normalize(fullName);
      this._options[normalizedName] = options;
    },

    getOptions: function (fullName) {
      var normalizedName = this.normalize(fullName);
      var options = this._options[normalizedName];
      if (options === undefined && this.fallback) {
        options = this.fallback.getOptions(fullName);
      }
      return options;
    },

    getOption: function (fullName, optionName) {
      var options = this._options[fullName];

      if (options && options[optionName] !== undefined) {
        return options[optionName];
      }

      var type = fullName.split(':')[0];
      options = this._typeOptions[type];

      if (options && options[optionName] !== undefined) {
        return options[optionName];
      } else if (this.fallback) {
        return this.fallback.getOption(fullName, optionName);
      }
    },

    /**
     Used only via `injection`.
      Provides a specialized form of injection, specifically enabling
     all objects of one type to be injected with a reference to another
     object.
      For example, provided each object of type `controller` needed a `router`.
     one would do the following:
      ```javascript
     var registry = new Registry();
     var container = registry.container();
      registry.register('router:main', Router);
     registry.register('controller:user', UserController);
     registry.register('controller:post', PostController);
      registry.typeInjection('controller', 'router', 'router:main');
      var user = container.lookup('controller:user');
     var post = container.lookup('controller:post');
      user.router instanceof Router; //=> true
     post.router instanceof Router; //=> true
      // both controllers share the same router
     user.router === post.router; //=> true
     ```
      @private
     @method typeInjection
     @param {String} type
     @param {String} property
     @param {String} fullName
     */
    typeInjection: function (type, property, fullName) {
      _emberMetalDebug.assert('fullName must be a proper full name', this.validateFullName(fullName));

      var fullNameType = fullName.split(':')[0];
      if (fullNameType === type) {
        throw new Error('Cannot inject a `' + fullName + '` on other ' + type + '(s).');
      }

      var injections = this._typeInjections[type] || (this._typeInjections[type] = []);

      injections.push({
        property: property,
        fullName: fullName
      });
    },

    /**
     Defines injection rules.
      These rules are used to inject dependencies onto objects when they
     are instantiated.
      Two forms of injections are possible:
      * Injecting one fullName on another fullName
     * Injecting one fullName on a type
      Example:
      ```javascript
     var registry = new Registry();
     var container = registry.container();
      registry.register('source:main', Source);
     registry.register('model:user', User);
     registry.register('model:post', Post);
      // injecting one fullName on another fullName
     // eg. each user model gets a post model
     registry.injection('model:user', 'post', 'model:post');
      // injecting one fullName on another type
     registry.injection('model', 'source', 'source:main');
      var user = container.lookup('model:user');
     var post = container.lookup('model:post');
      user.source instanceof Source; //=> true
     post.source instanceof Source; //=> true
      user.post instanceof Post; //=> true
      // and both models share the same source
     user.source === post.source; //=> true
     ```
      @private
     @method injection
     @param {String} factoryName
     @param {String} property
     @param {String} injectionName
     */
    injection: function (fullName, property, injectionName) {
      this.validateFullName(injectionName);
      var normalizedInjectionName = this.normalize(injectionName);

      if (fullName.indexOf(':') === -1) {
        return this.typeInjection(fullName, property, normalizedInjectionName);
      }

      _emberMetalDebug.assert('fullName must be a proper full name', this.validateFullName(fullName));
      var normalizedName = this.normalize(fullName);

      var injections = this._injections[normalizedName] || (this._injections[normalizedName] = []);

      injections.push({
        property: property,
        fullName: normalizedInjectionName
      });
    },

    /**
     Used only via `factoryInjection`.
      Provides a specialized form of injection, specifically enabling
     all factory of one type to be injected with a reference to another
     object.
      For example, provided each factory of type `model` needed a `store`.
     one would do the following:
      ```javascript
     var registry = new Registry();
      registry.register('store:main', SomeStore);
      registry.factoryTypeInjection('model', 'store', 'store:main');
      var store = registry.lookup('store:main');
     var UserFactory = registry.lookupFactory('model:user');
      UserFactory.store instanceof SomeStore; //=> true
     ```
      @private
     @method factoryTypeInjection
     @param {String} type
     @param {String} property
     @param {String} fullName
     */
    factoryTypeInjection: function (type, property, fullName) {
      var injections = this._factoryTypeInjections[type] || (this._factoryTypeInjections[type] = []);

      injections.push({
        property: property,
        fullName: this.normalize(fullName)
      });
    },

    /**
     Defines factory injection rules.
      Similar to regular injection rules, but are run against factories, via
     `Registry#lookupFactory`.
      These rules are used to inject objects onto factories when they
     are looked up.
      Two forms of injections are possible:
      * Injecting one fullName on another fullName
     * Injecting one fullName on a type
      Example:
      ```javascript
     var registry = new Registry();
     var container = registry.container();
      registry.register('store:main', Store);
     registry.register('store:secondary', OtherStore);
     registry.register('model:user', User);
     registry.register('model:post', Post);
      // injecting one fullName on another type
     registry.factoryInjection('model', 'store', 'store:main');
      // injecting one fullName on another fullName
     registry.factoryInjection('model:post', 'secondaryStore', 'store:secondary');
      var UserFactory = container.lookupFactory('model:user');
     var PostFactory = container.lookupFactory('model:post');
     var store = container.lookup('store:main');
      UserFactory.store instanceof Store; //=> true
     UserFactory.secondaryStore instanceof OtherStore; //=> false
      PostFactory.store instanceof Store; //=> true
     PostFactory.secondaryStore instanceof OtherStore; //=> true
      // and both models share the same source instance
     UserFactory.store === PostFactory.store; //=> true
     ```
      @private
     @method factoryInjection
     @param {String} factoryName
     @param {String} property
     @param {String} injectionName
     */
    factoryInjection: function (fullName, property, injectionName) {
      var normalizedName = this.normalize(fullName);
      var normalizedInjectionName = this.normalize(injectionName);

      this.validateFullName(injectionName);

      if (fullName.indexOf(':') === -1) {
        return this.factoryTypeInjection(normalizedName, property, normalizedInjectionName);
      }

      var injections = this._factoryInjections[normalizedName] || (this._factoryInjections[normalizedName] = []);

      injections.push({
        property: property,
        fullName: normalizedInjectionName
      });
    },

    /**
     @private
     @method knownForType
     @param {String} type the type to iterate over
    */
    knownForType: function (type) {
      var fallbackKnown = undefined,
          resolverKnown = undefined;

      var localKnown = _emberMetalDictionary.default(null);
      var registeredNames = Object.keys(this.registrations);
      for (var index = 0, _length = registeredNames.length; index < _length; index++) {
        var fullName = registeredNames[index];
        var itemType = fullName.split(':')[0];

        if (itemType === type) {
          localKnown[fullName] = true;
        }
      }

      if (this.fallback) {
        fallbackKnown = this.fallback.knownForType(type);
      }

      if (this.resolver && this.resolver.knownForType) {
        resolverKnown = this.resolver.knownForType(type);
      }

      return _emberMetalAssign.default({}, fallbackKnown, localKnown, resolverKnown);
    },

    validateFullName: function (fullName) {
      if (!VALID_FULL_NAME_REGEXP.test(fullName)) {
        throw new TypeError('Invalid Fullname, expected: `type:name` got: ' + fullName);
      }
      return true;
    },

    validateInjections: function (injections) {
      if (!injections) {
        return;
      }

      var fullName;

      for (var i = 0, length = injections.length; i < length; i++) {
        fullName = injections[i].fullName;

        if (!this.has(fullName)) {
          throw new Error('Attempting to inject an unknown injection: `' + fullName + '`');
        }
      }
    },

    normalizeInjectionsHash: function (hash) {
      var injections = [];

      for (var key in hash) {
        if (hash.hasOwnProperty(key)) {
          _emberMetalDebug.assert('Expected a proper full name, given \'' + hash[key] + '\'', this.validateFullName(hash[key]));

          injections.push({
            property: key,
            fullName: hash[key]
          });
        }
      }

      return injections;
    },

    getInjections: function (fullName) {
      var injections = this._injections[fullName] || [];
      if (this.fallback) {
        injections = injections.concat(this.fallback.getInjections(fullName));
      }
      return injections;
    },

    getTypeInjections: function (type) {
      var injections = this._typeInjections[type] || [];
      if (this.fallback) {
        injections = injections.concat(this.fallback.getTypeInjections(type));
      }
      return injections;
    },

    getFactoryInjections: function (fullName) {
      var injections = this._factoryInjections[fullName] || [];
      if (this.fallback) {
        injections = injections.concat(this.fallback.getFactoryInjections(fullName));
      }
      return injections;
    },

    getFactoryTypeInjections: function (type) {
      var injections = this._factoryTypeInjections[type] || [];
      if (this.fallback) {
        injections = injections.concat(this.fallback.getFactoryTypeInjections(type));
      }
      return injections;
    }
  };

  function deprecateResolverFunction(registry) {
    _emberMetalDebug.deprecate('Passing a `resolver` function into a Registry is deprecated. Please pass in a Resolver object with a `resolve` method.', false, { id: 'ember-application.registry-resolver-as-function', until: '3.0.0', url: 'http://emberjs.com/deprecations/v2.x#toc_registry-resolver-as-function' });
    registry.resolver = {
      resolve: registry.resolver
    };
  }

  function resolve(registry, normalizedName) {
    var cached = registry._resolveCache[normalizedName];
    if (cached) {
      return cached;
    }
    if (registry._failCache[normalizedName]) {
      return;
    }

    var resolved = undefined;

    if (registry.resolver) {
      resolved = registry.resolver.resolve(normalizedName);
    }

    resolved = resolved || registry.registrations[normalizedName];

    if (resolved) {
      registry._resolveCache[normalizedName] = resolved;
    } else {
      registry._failCache[normalizedName] = true;
    }

    return resolved;
  }

  function has(registry, fullName) {
    return registry.resolve(fullName) !== undefined;
  }

  exports.default = Registry;
});
enifed('container', ['exports', 'ember-metal/core', 'container/registry', 'container/container', 'container/owner'], function (exports, _emberMetalCore, _containerRegistry, _containerContainer, _containerOwner) {
  'use strict';

  /*
  Public api for the container is still in flux.
  The public api, specified on the application namespace should be considered the stable api.
  // @module container
    @private
  */

  /*
   Flag to enable/disable model factory injections (disabled by default)
   If model factory injections are enabled, models should not be
   accessed globally (only through `container.lookupFactory('model:modelName'))`);
  */
  _emberMetalCore.default.MODEL_FACTORY_INJECTIONS = false;

  if (_emberMetalCore.default.ENV && typeof _emberMetalCore.default.ENV.MODEL_FACTORY_INJECTIONS !== 'undefined') {
    _emberMetalCore.default.MODEL_FACTORY_INJECTIONS = !!_emberMetalCore.default.ENV.MODEL_FACTORY_INJECTIONS;
  }

  exports.Registry = _containerRegistry.default;
  exports.Container = _containerContainer.default;
  exports.getOwner = _containerOwner.getOwner;
  exports.setOwner = _containerOwner.setOwner;
});
enifed('dag-map/platform', ['exports'], function (exports) {
  'use strict';

  var platform;

  /* global self */
  if (typeof self === 'object') {
    platform = self;

    /* global global */
  } else if (typeof global === 'object') {
      platform = global;
    } else {
      throw new Error('no global: `self` or `global` found');
    }

  exports.default = platform;
});
enifed('dag-map', ['exports', 'vertex', 'visit'], function (exports, _vertex, _visit) {
  'use strict';

  exports.default = DAG;

  /**
   * DAG stands for Directed acyclic graph.
   *
   * It is used to build a graph of dependencies checking that there isn't circular
   * dependencies. p.e Registering initializers with a certain precedence order.
   *
   * @class DAG
   * @constructor
   */

  function DAG() {
    this.names = [];
    this.vertices = Object.create(null);
  }

  /**
   * Adds a vertex entry to the graph unless it is already added.
   *
   * @private
   * @method add
   * @param {String} name The name of the vertex to add
   */
  DAG.prototype.add = function (name) {
    if (!name) {
      throw new Error("Can't add Vertex without name");
    }
    if (this.vertices[name] !== undefined) {
      return this.vertices[name];
    }
    var vertex = new _vertex.default(name);
    this.vertices[name] = vertex;
    this.names.push(name);
    return vertex;
  };

  /**
   * Adds a vertex to the graph and sets its value.
   *
   * @private
   * @method map
   * @param {String} name The name of the vertex.
   * @param         value The value to put in the vertex.
   */
  DAG.prototype.map = function (name, value) {
    this.add(name).value = value;
  };

  /**
   * Connects the vertices with the given names, adding them to the graph if
   * necessary, only if this does not produce is any circular dependency.
   *
   * @private
   * @method addEdge
   * @param {String} fromName The name the vertex where the edge starts.
   * @param {String} toName The name the vertex where the edge ends.
   */
  DAG.prototype.addEdge = function (fromName, toName) {
    if (!fromName || !toName || fromName === toName) {
      return;
    }
    var from = this.add(fromName);
    var to = this.add(toName);
    if (to.incoming.hasOwnProperty(fromName)) {
      return;
    }
    function checkCycle(vertex, path) {
      if (vertex.name === toName) {
        throw new Error("cycle detected: " + toName + " <- " + path.join(" <- "));
      }
    }
    _visit.default(from, checkCycle);
    from.hasOutgoing = true;
    to.incoming[fromName] = from;
    to.incomingNames.push(fromName);
  };

  /**
   * Visits all the vertex of the graph calling the given function with each one,
   * ensuring that the vertices are visited respecting their precedence.
   *
   * @method  topsort
   * @param {Function} fn The function to be invoked on each vertex.
   */
  DAG.prototype.topsort = function (fn) {
    var visited = {};
    var vertices = this.vertices;
    var names = this.names;
    var len = names.length;
    var i, vertex;

    for (i = 0; i < len; i++) {
      vertex = vertices[names[i]];
      if (!vertex.hasOutgoing) {
        _visit.default(vertex, fn, visited);
      }
    }
  };

  /**
   * Adds a vertex with the given name and value to the graph and joins it with the
   * vertices referenced in _before_ and _after_. If there isn't vertices with those
   * names, they are added too.
   *
   * If either _before_ or _after_ are falsy/empty, the added vertex will not have
   * an incoming/outgoing edge.
   *
   * @method addEdges
   * @param {String} name The name of the vertex to be added.
   * @param         value The value of that vertex.
   * @param        before An string or array of strings with the names of the vertices before
   *                      which this vertex must be visited.
   * @param         after An string or array of strings with the names of the vertex after
   *                      which this vertex must be visited.
   *
   */
  DAG.prototype.addEdges = function (name, value, before, after) {
    var i;
    this.map(name, value);
    if (before) {
      if (typeof before === 'string') {
        this.addEdge(name, before);
      } else {
        for (i = 0; i < before.length; i++) {
          this.addEdge(name, before[i]);
        }
      }
    }
    if (after) {
      if (typeof after === 'string') {
        this.addEdge(after, name);
      } else {
        for (i = 0; i < after.length; i++) {
          this.addEdge(after[i], name);
        }
      }
    }
  };
});
enifed('dag-map.umd', ['exports', 'dag-map/platform', 'dag-map'], function (exports, _dagMapPlatform, _dagMap) {
  'use strict';

  /* global define:true module:true window: true */
  if (typeof define === 'function' && define.amd) {
    define(function () {
      return _dagMap.default;
    });
  } else if (typeof module !== 'undefined' && module.exports) {
    module.exports = _dagMap.default;
  } else if (typeof _dagMapPlatform.default !== 'undefined') {
    _dagMapPlatform.default['DAG'] = _dagMap.default;
  }
});
enifed('dom-helper/build-html-dom', ['exports'], function (exports) {
  /* global XMLSerializer:false */
  'use strict';

  var svgHTMLIntegrationPoints = { foreignObject: 1, desc: 1, title: 1 };
  exports.svgHTMLIntegrationPoints = svgHTMLIntegrationPoints;
  var svgNamespace = 'http://www.w3.org/2000/svg';

  exports.svgNamespace = svgNamespace;
  var doc = typeof document === 'undefined' ? false : document;

  // Safari does not like using innerHTML on SVG HTML integration
  // points (desc/title/foreignObject).
  var needsIntegrationPointFix = doc && (function (document) {
    if (document.createElementNS === undefined) {
      return;
    }
    // In FF title will not accept innerHTML.
    var testEl = document.createElementNS(svgNamespace, 'title');
    testEl.innerHTML = "<div></div>";
    return testEl.childNodes.length === 0 || testEl.childNodes[0].nodeType !== 1;
  })(doc);

  // Internet Explorer prior to 9 does not allow setting innerHTML if the first element
  // is a "zero-scope" element. This problem can be worked around by making
  // the first node an invisible text node. We, like Modernizr, use &shy;
  var needsShy = doc && (function (document) {
    var testEl = document.createElement('div');
    testEl.innerHTML = "<div></div>";
    testEl.firstChild.innerHTML = "<script><\/script>";
    return testEl.firstChild.innerHTML === '';
  })(doc);

  // IE 8 (and likely earlier) likes to move whitespace preceeding
  // a script tag to appear after it. This means that we can
  // accidentally remove whitespace when updating a morph.
  var movesWhitespace = doc && (function (document) {
    var testEl = document.createElement('div');
    testEl.innerHTML = "Test: <script type='text/x-placeholder'><\/script>Value";
    return testEl.childNodes[0].nodeValue === 'Test:' && testEl.childNodes[2].nodeValue === ' Value';
  })(doc);

  var tagNamesRequiringInnerHTMLFix = doc && (function (document) {
    var tagNamesRequiringInnerHTMLFix;
    // IE 9 and earlier don't allow us to set innerHTML on col, colgroup, frameset,
    // html, style, table, tbody, tfoot, thead, title, tr. Detect this and add
    // them to an initial list of corrected tags.
    //
    // Here we are only dealing with the ones which can have child nodes.
    //
    var tableNeedsInnerHTMLFix;
    var tableInnerHTMLTestElement = document.createElement('table');
    try {
      tableInnerHTMLTestElement.innerHTML = '<tbody></tbody>';
    } catch (e) {} finally {
      tableNeedsInnerHTMLFix = tableInnerHTMLTestElement.childNodes.length === 0;
    }
    if (tableNeedsInnerHTMLFix) {
      tagNamesRequiringInnerHTMLFix = {
        colgroup: ['table'],
        table: [],
        tbody: ['table'],
        tfoot: ['table'],
        thead: ['table'],
        tr: ['table', 'tbody']
      };
    }

    // IE 8 doesn't allow setting innerHTML on a select tag. Detect this and
    // add it to the list of corrected tags.
    //
    var selectInnerHTMLTestElement = document.createElement('select');
    selectInnerHTMLTestElement.innerHTML = '<option></option>';
    if (!selectInnerHTMLTestElement.childNodes[0]) {
      tagNamesRequiringInnerHTMLFix = tagNamesRequiringInnerHTMLFix || {};
      tagNamesRequiringInnerHTMLFix.select = [];
    }
    return tagNamesRequiringInnerHTMLFix;
  })(doc);

  function scriptSafeInnerHTML(element, html) {
    // without a leading text node, IE will drop a leading script tag.
    html = '&shy;' + html;

    element.innerHTML = html;

    var nodes = element.childNodes;

    // Look for &shy; to remove it.
    var shyElement = nodes[0];
    while (shyElement.nodeType === 1 && !shyElement.nodeName) {
      shyElement = shyElement.firstChild;
    }
    // At this point it's the actual unicode character.
    if (shyElement.nodeType === 3 && shyElement.nodeValue.charAt(0) === "\u00AD") {
      var newValue = shyElement.nodeValue.slice(1);
      if (newValue.length) {
        shyElement.nodeValue = shyElement.nodeValue.slice(1);
      } else {
        shyElement.parentNode.removeChild(shyElement);
      }
    }

    return nodes;
  }

  function buildDOMWithFix(html, contextualElement) {
    var tagName = contextualElement.tagName;

    // Firefox versions < 11 do not have support for element.outerHTML.
    var outerHTML = contextualElement.outerHTML || new XMLSerializer().serializeToString(contextualElement);
    if (!outerHTML) {
      throw "Can't set innerHTML on " + tagName + " in this browser";
    }

    html = fixSelect(html, contextualElement);

    var wrappingTags = tagNamesRequiringInnerHTMLFix[tagName.toLowerCase()];

    var startTag = outerHTML.match(new RegExp("<" + tagName + "([^>]*)>", 'i'))[0];
    var endTag = '</' + tagName + '>';

    var wrappedHTML = [startTag, html, endTag];

    var i = wrappingTags.length;
    var wrappedDepth = 1 + i;
    while (i--) {
      wrappedHTML.unshift('<' + wrappingTags[i] + '>');
      wrappedHTML.push('</' + wrappingTags[i] + '>');
    }

    var wrapper = document.createElement('div');
    scriptSafeInnerHTML(wrapper, wrappedHTML.join(''));
    var element = wrapper;
    while (wrappedDepth--) {
      element = element.firstChild;
      while (element && element.nodeType !== 1) {
        element = element.nextSibling;
      }
    }
    while (element && element.tagName !== tagName) {
      element = element.nextSibling;
    }
    return element ? element.childNodes : [];
  }

  var buildDOM;
  if (needsShy) {
    buildDOM = function buildDOM(html, contextualElement, dom) {
      html = fixSelect(html, contextualElement);

      contextualElement = dom.cloneNode(contextualElement, false);
      scriptSafeInnerHTML(contextualElement, html);
      return contextualElement.childNodes;
    };
  } else {
    buildDOM = function buildDOM(html, contextualElement, dom) {
      html = fixSelect(html, contextualElement);

      contextualElement = dom.cloneNode(contextualElement, false);
      contextualElement.innerHTML = html;
      return contextualElement.childNodes;
    };
  }

  function fixSelect(html, contextualElement) {
    if (contextualElement.tagName === 'SELECT') {
      html = "<option></option>" + html;
    }

    return html;
  }

  var buildIESafeDOM;
  if (tagNamesRequiringInnerHTMLFix || movesWhitespace) {
    buildIESafeDOM = function buildIESafeDOM(html, contextualElement, dom) {
      // Make a list of the leading text on script nodes. Include
      // script tags without any whitespace for easier processing later.
      var spacesBefore = [];
      var spacesAfter = [];
      if (typeof html === 'string') {
        html = html.replace(/(\s*)(<script)/g, function (match, spaces, tag) {
          spacesBefore.push(spaces);
          return tag;
        });

        html = html.replace(/(<\/script>)(\s*)/g, function (match, tag, spaces) {
          spacesAfter.push(spaces);
          return tag;
        });
      }

      // Fetch nodes
      var nodes;
      if (tagNamesRequiringInnerHTMLFix[contextualElement.tagName.toLowerCase()]) {
        // buildDOMWithFix uses string wrappers for problematic innerHTML.
        nodes = buildDOMWithFix(html, contextualElement);
      } else {
        nodes = buildDOM(html, contextualElement, dom);
      }

      // Build a list of script tags, the nodes themselves will be
      // mutated as we add test nodes.
      var i, j, node, nodeScriptNodes;
      var scriptNodes = [];
      for (i = 0; i < nodes.length; i++) {
        node = nodes[i];
        if (node.nodeType !== 1) {
          continue;
        }
        if (node.tagName === 'SCRIPT') {
          scriptNodes.push(node);
        } else {
          nodeScriptNodes = node.getElementsByTagName('script');
          for (j = 0; j < nodeScriptNodes.length; j++) {
            scriptNodes.push(nodeScriptNodes[j]);
          }
        }
      }

      // Walk the script tags and put back their leading text nodes.
      var scriptNode, textNode, spaceBefore, spaceAfter;
      for (i = 0; i < scriptNodes.length; i++) {
        scriptNode = scriptNodes[i];
        spaceBefore = spacesBefore[i];
        if (spaceBefore && spaceBefore.length > 0) {
          textNode = dom.document.createTextNode(spaceBefore);
          scriptNode.parentNode.insertBefore(textNode, scriptNode);
        }

        spaceAfter = spacesAfter[i];
        if (spaceAfter && spaceAfter.length > 0) {
          textNode = dom.document.createTextNode(spaceAfter);
          scriptNode.parentNode.insertBefore(textNode, scriptNode.nextSibling);
        }
      }

      return nodes;
    };
  } else {
    buildIESafeDOM = buildDOM;
  }

  var buildHTMLDOM;
  if (needsIntegrationPointFix) {
    exports.buildHTMLDOM = buildHTMLDOM = function buildHTMLDOM(html, contextualElement, dom) {
      if (svgHTMLIntegrationPoints[contextualElement.tagName]) {
        return buildIESafeDOM(html, document.createElement('div'), dom);
      } else {
        return buildIESafeDOM(html, contextualElement, dom);
      }
    };
  } else {
    exports.buildHTMLDOM = buildHTMLDOM = buildIESafeDOM;
  }

  exports.buildHTMLDOM = buildHTMLDOM;
});
enifed('dom-helper/classes', ['exports'], function (exports) {
  'use strict';

  var doc = typeof document === 'undefined' ? false : document;

  // PhantomJS has a broken classList. See https://github.com/ariya/phantomjs/issues/12782
  var canClassList = doc && (function () {
    var d = document.createElement('div');
    if (!d.classList) {
      return false;
    }
    d.classList.add('boo');
    d.classList.add('boo', 'baz');
    return d.className === 'boo baz';
  })();

  function buildClassList(element) {
    var classString = element.getAttribute('class') || '';
    return classString !== '' && classString !== ' ' ? classString.split(' ') : [];
  }

  function intersect(containingArray, valuesArray) {
    var containingIndex = 0;
    var containingLength = containingArray.length;
    var valuesIndex = 0;
    var valuesLength = valuesArray.length;

    var intersection = new Array(valuesLength);

    // TODO: rewrite this loop in an optimal manner
    for (; containingIndex < containingLength; containingIndex++) {
      valuesIndex = 0;
      for (; valuesIndex < valuesLength; valuesIndex++) {
        if (valuesArray[valuesIndex] === containingArray[containingIndex]) {
          intersection[valuesIndex] = containingIndex;
          break;
        }
      }
    }

    return intersection;
  }

  function addClassesViaAttribute(element, classNames) {
    var existingClasses = buildClassList(element);

    var indexes = intersect(existingClasses, classNames);
    var didChange = false;

    for (var i = 0, l = classNames.length; i < l; i++) {
      if (indexes[i] === undefined) {
        didChange = true;
        existingClasses.push(classNames[i]);
      }
    }

    if (didChange) {
      element.setAttribute('class', existingClasses.length > 0 ? existingClasses.join(' ') : '');
    }
  }

  function removeClassesViaAttribute(element, classNames) {
    var existingClasses = buildClassList(element);

    var indexes = intersect(classNames, existingClasses);
    var didChange = false;
    var newClasses = [];

    for (var i = 0, l = existingClasses.length; i < l; i++) {
      if (indexes[i] === undefined) {
        newClasses.push(existingClasses[i]);
      } else {
        didChange = true;
      }
    }

    if (didChange) {
      element.setAttribute('class', newClasses.length > 0 ? newClasses.join(' ') : '');
    }
  }

  var addClasses, removeClasses;
  if (canClassList) {
    exports.addClasses = addClasses = function addClasses(element, classNames) {
      if (element.classList) {
        if (classNames.length === 1) {
          element.classList.add(classNames[0]);
        } else if (classNames.length === 2) {
          element.classList.add(classNames[0], classNames[1]);
        } else {
          element.classList.add.apply(element.classList, classNames);
        }
      } else {
        addClassesViaAttribute(element, classNames);
      }
    };
    exports.removeClasses = removeClasses = function removeClasses(element, classNames) {
      if (element.classList) {
        if (classNames.length === 1) {
          element.classList.remove(classNames[0]);
        } else if (classNames.length === 2) {
          element.classList.remove(classNames[0], classNames[1]);
        } else {
          element.classList.remove.apply(element.classList, classNames);
        }
      } else {
        removeClassesViaAttribute(element, classNames);
      }
    };
  } else {
    exports.addClasses = addClasses = addClassesViaAttribute;
    exports.removeClasses = removeClasses = removeClassesViaAttribute;
  }

  exports.addClasses = addClasses;
  exports.removeClasses = removeClasses;
});
enifed('dom-helper/prop', ['exports'], function (exports) {
  'use strict';

  exports.isAttrRemovalValue = isAttrRemovalValue;
  exports.normalizeProperty = normalizeProperty;

  function isAttrRemovalValue(value) {
    return value === null || value === undefined;
  }

  /*
   *
   * @method normalizeProperty
   * @param element {HTMLElement}
   * @param slotName {String}
   * @returns {Object} { name, type }
   */

  function normalizeProperty(element, slotName) {
    var type, normalized;

    if (slotName in element) {
      normalized = slotName;
      type = 'prop';
    } else {
      var lower = slotName.toLowerCase();
      if (lower in element) {
        type = 'prop';
        normalized = lower;
      } else {
        type = 'attr';
        normalized = slotName;
      }
    }

    if (type === 'prop' && (normalized.toLowerCase() === 'style' || preferAttr(element.tagName, normalized))) {
      type = 'attr';
    }

    return { normalized: normalized, type: type };
  }

  // properties that MUST be set as attributes, due to:
  // * browser bug
  // * strange spec outlier
  var ATTR_OVERRIDES = {

    // phantomjs < 2.0 lets you set it as a prop but won't reflect it
    // back to the attribute. button.getAttribute('type') === null
    BUTTON: { type: true, form: true },

    INPUT: {
      // TODO: remove when IE8 is droped
      // Some versions of IE (IE8) throw an exception when setting
      // `input.list = 'somestring'`:
      // https://github.com/emberjs/ember.js/issues/10908
      // https://github.com/emberjs/ember.js/issues/11364
      list: true,
      // Some version of IE (like IE9) actually throw an exception
      // if you set input.type = 'something-unknown'
      type: true,
      form: true,
      // Chrome 46.0.2464.0: 'autocorrect' in document.createElement('input') === false
      // Safari 8.0.7: 'autocorrect' in document.createElement('input') === false
      // Mobile Safari (iOS 8.4 simulator): 'autocorrect' in document.createElement('input') === true
      autocorrect: true
    },

    // element.form is actually a legitimate readOnly property, that is to be
    // mutated, but must be mutated by setAttribute...
    SELECT: { form: true },
    OPTION: { form: true },
    TEXTAREA: { form: true },
    LABEL: { form: true },
    FIELDSET: { form: true },
    LEGEND: { form: true },
    OBJECT: { form: true }
  };

  function preferAttr(tagName, propName) {
    var tag = ATTR_OVERRIDES[tagName.toUpperCase()];
    return tag && tag[propName.toLowerCase()] || false;
  }
});
enifed("dom-helper", ["exports", "htmlbars-runtime/morph", "morph-attr", "dom-helper/build-html-dom", "dom-helper/classes", "dom-helper/prop"], function (exports, _htmlbarsRuntimeMorph, _morphAttr, _domHelperBuildHtmlDom, _domHelperClasses, _domHelperProp) {
  /*globals module, URL*/

  "use strict";

  var doc = typeof document === 'undefined' ? false : document;

  var deletesBlankTextNodes = doc && (function (document) {
    var element = document.createElement('div');
    element.appendChild(document.createTextNode(''));
    var clonedElement = element.cloneNode(true);
    return clonedElement.childNodes.length === 0;
  })(doc);

  var ignoresCheckedAttribute = doc && (function (document) {
    var element = document.createElement('input');
    element.setAttribute('checked', 'checked');
    var clonedElement = element.cloneNode(false);
    return !clonedElement.checked;
  })(doc);

  var canRemoveSvgViewBoxAttribute = doc && (doc.createElementNS ? (function (document) {
    var element = document.createElementNS(_domHelperBuildHtmlDom.svgNamespace, 'svg');
    element.setAttribute('viewBox', '0 0 100 100');
    element.removeAttribute('viewBox');
    return !element.getAttribute('viewBox');
  })(doc) : true);

  var canClone = doc && (function (document) {
    var element = document.createElement('div');
    element.appendChild(document.createTextNode(' '));
    element.appendChild(document.createTextNode(' '));
    var clonedElement = element.cloneNode(true);
    return clonedElement.childNodes[0].nodeValue === ' ';
  })(doc);

  // This is not the namespace of the element, but of
  // the elements inside that elements.
  function interiorNamespace(element) {
    if (element && element.namespaceURI === _domHelperBuildHtmlDom.svgNamespace && !_domHelperBuildHtmlDom.svgHTMLIntegrationPoints[element.tagName]) {
      return _domHelperBuildHtmlDom.svgNamespace;
    } else {
      return null;
    }
  }

  // The HTML spec allows for "omitted start tags". These tags are optional
  // when their intended child is the first thing in the parent tag. For
  // example, this is a tbody start tag:
  //
  // <table>
  //   <tbody>
  //     <tr>
  //
  // The tbody may be omitted, and the browser will accept and render:
  //
  // <table>
  //   <tr>
  //
  // However, the omitted start tag will still be added to the DOM. Here
  // we test the string and context to see if the browser is about to
  // perform this cleanup.
  //
  // http://www.whatwg.org/specs/web-apps/current-work/multipage/syntax.html#optional-tags
  // describes which tags are omittable. The spec for tbody and colgroup
  // explains this behavior:
  //
  // http://www.whatwg.org/specs/web-apps/current-work/multipage/tables.html#the-tbody-element
  // http://www.whatwg.org/specs/web-apps/current-work/multipage/tables.html#the-colgroup-element
  //

  var omittedStartTagChildTest = /<([\w:]+)/;
  function detectOmittedStartTag(string, contextualElement) {
    // Omitted start tags are only inside table tags.
    if (contextualElement.tagName === 'TABLE') {
      var omittedStartTagChildMatch = omittedStartTagChildTest.exec(string);
      if (omittedStartTagChildMatch) {
        var omittedStartTagChild = omittedStartTagChildMatch[1];
        // It is already asserted that the contextual element is a table
        // and not the proper start tag. Just see if a tag was omitted.
        return omittedStartTagChild === 'tr' || omittedStartTagChild === 'col';
      }
    }
  }

  function buildSVGDOM(html, dom) {
    var div = dom.document.createElement('div');
    div.innerHTML = '<svg>' + html + '</svg>';
    return div.firstChild.childNodes;
  }

  var guid = 1;

  function ElementMorph(element, dom, namespace) {
    this.element = element;
    this.dom = dom;
    this.namespace = namespace;
    this.guid = "element" + guid++;

    this._state = undefined;
    this.isDirty = true;
  }

  ElementMorph.prototype.getState = function () {
    if (!this._state) {
      this._state = {};
    }

    return this._state;
  };

  ElementMorph.prototype.setState = function (newState) {
    /*jshint -W093 */

    return this._state = newState;
  };

  // renderAndCleanup calls `clear` on all items in the morph map
  // just before calling `destroy` on the morph.
  //
  // As a future refactor this could be changed to set the property
  // back to its original/default value.
  ElementMorph.prototype.clear = function () {};

  ElementMorph.prototype.destroy = function () {
    this.element = null;
    this.dom = null;
  };

  /*
   * A class wrapping DOM functions to address environment compatibility,
   * namespaces, contextual elements for morph un-escaped content
   * insertion.
   *
   * When entering a template, a DOMHelper should be passed:
   *
   *   template(context, { hooks: hooks, dom: new DOMHelper() });
   *
   * TODO: support foreignObject as a passed contextual element. It has
   * a namespace (svg) that does not match its internal namespace
   * (xhtml).
   *
   * @class DOMHelper
   * @constructor
   * @param {HTMLDocument} _document The document DOM methods are proxied to
   */
  function DOMHelper(_document) {
    this.document = _document || document;
    if (!this.document) {
      throw new Error("A document object must be passed to the DOMHelper, or available on the global scope");
    }
    this.canClone = canClone;
    this.namespace = null;

    installEnvironmentSpecificMethods(this);
  }

  var prototype = DOMHelper.prototype;
  prototype.constructor = DOMHelper;

  prototype.getElementById = function (id, rootNode) {
    rootNode = rootNode || this.document;
    return rootNode.getElementById(id);
  };

  prototype.insertBefore = function (element, childElement, referenceChild) {
    return element.insertBefore(childElement, referenceChild);
  };

  prototype.appendChild = function (element, childElement) {
    return element.appendChild(childElement);
  };

  var itemAt;

  // It appears that sometimes, in yet to be itentified scenarios PhantomJS 2.0
  // crashes on childNodes.item(index), but works as expected with childNodes[index];
  //
  // Although it would be nice to move to childNodes[index] in all scenarios,
  // this would require SimpleDOM to maintain the childNodes array. This would be
  // quite costly, in both dev time and runtime.
  //
  // So instead, we choose the best possible method and call it a day.
  //
  /*global navigator */
  if (typeof navigator !== 'undefined' && navigator.userAgent.indexOf('PhantomJS')) {
    itemAt = function (nodes, index) {
      return nodes[index];
    };
  } else {
    itemAt = function (nodes, index) {
      return nodes.item(index);
    };
  }

  prototype.childAt = function (element, indices) {
    var child = element;

    for (var i = 0; i < indices.length; i++) {
      child = itemAt(child.childNodes, indices[i]);
    }

    return child;
  };

  // Note to a Fellow Implementor:
  // Ahh, accessing a child node at an index. Seems like it should be so simple,
  // doesn't it? Unfortunately, this particular method has caused us a surprising
  // amount of pain. As you'll note below, this method has been modified to walk
  // the linked list of child nodes rather than access the child by index
  // directly, even though there are two (2) APIs in the DOM that do this for us.
  // If you're thinking to yourself, "What an oversight! What an opportunity to
  // optimize this code!" then to you I say: stop! For I have a tale to tell.
  //
  // First, this code must be compatible with simple-dom for rendering on the
  // server where there is no real DOM. Previously, we accessed a child node
  // directly via `element.childNodes[index]`. While we *could* in theory do a
  // full-fidelity simulation of a live `childNodes` array, this is slow,
  // complicated and error-prone.
  //
  // "No problem," we thought, "we'll just use the similar
  // `childNodes.item(index)` API." Then, we could just implement our own `item`
  // method in simple-dom and walk the child node linked list there, allowing
  // us to retain the performance advantages of the (surely optimized) `item()`
  // API in the browser.
  //
  // Unfortunately, an enterprising soul named Samy Alzahrani discovered that in
  // IE8, accessing an item out-of-bounds via `item()` causes an exception where
  // other browsers return null. This necessitated a... check of
  // `childNodes.length`, bringing us back around to having to support a
  // full-fidelity `childNodes` array!
  //
  // Worst of all, Kris Selden investigated how browsers are actualy implemented
  // and discovered that they're all linked lists under the hood anyway. Accessing
  // `childNodes` requires them to allocate a new live collection backed by that
  // linked list, which is itself a rather expensive operation. Our assumed
  // optimization had backfired! That is the danger of magical thinking about
  // the performance of native implementations.
  //
  // And this, my friends, is why the following implementation just walks the
  // linked list, as surprised as that may make you. Please ensure you understand
  // the above before changing this and submitting a PR.
  //
  // Tom Dale, January 18th, 2015, Portland OR
  prototype.childAtIndex = function (element, index) {
    var node = element.firstChild;

    for (var idx = 0; node && idx < index; idx++) {
      node = node.nextSibling;
    }

    return node;
  };

  prototype.appendText = function (element, text) {
    return element.appendChild(this.document.createTextNode(text));
  };

  prototype.setAttribute = function (element, name, value) {
    element.setAttribute(name, String(value));
  };

  prototype.getAttribute = function (element, name) {
    return element.getAttribute(name);
  };

  prototype.setAttributeNS = function (element, namespace, name, value) {
    element.setAttributeNS(namespace, name, String(value));
  };

  prototype.getAttributeNS = function (element, namespace, name) {
    return element.getAttributeNS(namespace, name);
  };

  if (canRemoveSvgViewBoxAttribute) {
    prototype.removeAttribute = function (element, name) {
      element.removeAttribute(name);
    };
  } else {
    prototype.removeAttribute = function (element, name) {
      if (element.tagName === 'svg' && name === 'viewBox') {
        element.setAttribute(name, null);
      } else {
        element.removeAttribute(name);
      }
    };
  }

  prototype.setPropertyStrict = function (element, name, value) {
    if (value === undefined) {
      value = null;
    }

    if (value === null && (name === 'value' || name === 'type' || name === 'src')) {
      value = '';
    }

    element[name] = value;
  };

  prototype.getPropertyStrict = function (element, name) {
    return element[name];
  };

  prototype.setProperty = function (element, name, value, namespace) {
    if (element.namespaceURI === _domHelperBuildHtmlDom.svgNamespace) {
      if (_domHelperProp.isAttrRemovalValue(value)) {
        element.removeAttribute(name);
      } else {
        if (namespace) {
          element.setAttributeNS(namespace, name, value);
        } else {
          element.setAttribute(name, value);
        }
      }
    } else {
      var _normalizeProperty = _domHelperProp.normalizeProperty(element, name);

      var normalized = _normalizeProperty.normalized;
      var type = _normalizeProperty.type;

      if (type === 'prop') {
        element[normalized] = value;
      } else {
        if (_domHelperProp.isAttrRemovalValue(value)) {
          element.removeAttribute(name);
        } else {
          if (namespace && element.setAttributeNS) {
            element.setAttributeNS(namespace, name, value);
          } else {
            element.setAttribute(name, value);
          }
        }
      }
    }
  };

  if (doc && doc.createElementNS) {
    // Only opt into namespace detection if a contextualElement
    // is passed.
    prototype.createElement = function (tagName, contextualElement) {
      var namespace = this.namespace;
      if (contextualElement) {
        if (tagName === 'svg') {
          namespace = _domHelperBuildHtmlDom.svgNamespace;
        } else {
          namespace = interiorNamespace(contextualElement);
        }
      }
      if (namespace) {
        return this.document.createElementNS(namespace, tagName);
      } else {
        return this.document.createElement(tagName);
      }
    };
    prototype.setAttributeNS = function (element, namespace, name, value) {
      element.setAttributeNS(namespace, name, String(value));
    };
  } else {
    prototype.createElement = function (tagName) {
      return this.document.createElement(tagName);
    };
    prototype.setAttributeNS = function (element, namespace, name, value) {
      element.setAttribute(name, String(value));
    };
  }

  prototype.addClasses = _domHelperClasses.addClasses;
  prototype.removeClasses = _domHelperClasses.removeClasses;

  prototype.setNamespace = function (ns) {
    this.namespace = ns;
  };

  prototype.detectNamespace = function (element) {
    this.namespace = interiorNamespace(element);
  };

  prototype.createDocumentFragment = function () {
    return this.document.createDocumentFragment();
  };

  prototype.createTextNode = function (text) {
    return this.document.createTextNode(text);
  };

  prototype.createComment = function (text) {
    return this.document.createComment(text);
  };

  prototype.repairClonedNode = function (element, blankChildTextNodes, isChecked) {
    if (deletesBlankTextNodes && blankChildTextNodes.length > 0) {
      for (var i = 0, len = blankChildTextNodes.length; i < len; i++) {
        var textNode = this.document.createTextNode(''),
            offset = blankChildTextNodes[i],
            before = this.childAtIndex(element, offset);
        if (before) {
          element.insertBefore(textNode, before);
        } else {
          element.appendChild(textNode);
        }
      }
    }
    if (ignoresCheckedAttribute && isChecked) {
      element.setAttribute('checked', 'checked');
    }
  };

  prototype.cloneNode = function (element, deep) {
    var clone = element.cloneNode(!!deep);
    return clone;
  };

  prototype.AttrMorphClass = _morphAttr.default;

  prototype.createAttrMorph = function (element, attrName, namespace) {
    return this.AttrMorphClass.create(element, attrName, this, namespace);
  };

  prototype.ElementMorphClass = ElementMorph;

  prototype.createElementMorph = function (element, namespace) {
    return new this.ElementMorphClass(element, this, namespace);
  };

  prototype.createUnsafeAttrMorph = function (element, attrName, namespace) {
    var morph = this.createAttrMorph(element, attrName, namespace);
    morph.escaped = false;
    return morph;
  };

  prototype.MorphClass = _htmlbarsRuntimeMorph.default;

  prototype.createMorph = function (parent, start, end, contextualElement) {
    if (contextualElement && contextualElement.nodeType === 11) {
      throw new Error("Cannot pass a fragment as the contextual element to createMorph");
    }

    if (!contextualElement && parent && parent.nodeType === 1) {
      contextualElement = parent;
    }
    var morph = new this.MorphClass(this, contextualElement);
    morph.firstNode = start;
    morph.lastNode = end;
    return morph;
  };

  prototype.createFragmentMorph = function (contextualElement) {
    if (contextualElement && contextualElement.nodeType === 11) {
      throw new Error("Cannot pass a fragment as the contextual element to createMorph");
    }

    var fragment = this.createDocumentFragment();
    return _htmlbarsRuntimeMorph.default.create(this, contextualElement, fragment);
  };

  prototype.replaceContentWithMorph = function (element) {
    var firstChild = element.firstChild;

    if (!firstChild) {
      var comment = this.createComment('');
      this.appendChild(element, comment);
      return _htmlbarsRuntimeMorph.default.create(this, element, comment);
    } else {
      var morph = _htmlbarsRuntimeMorph.default.attach(this, element, firstChild, element.lastChild);
      morph.clear();
      return morph;
    }
  };

  prototype.createUnsafeMorph = function (parent, start, end, contextualElement) {
    var morph = this.createMorph(parent, start, end, contextualElement);
    morph.parseTextAsHTML = true;
    return morph;
  };

  // This helper is just to keep the templates good looking,
  // passing integers instead of element references.
  prototype.createMorphAt = function (parent, startIndex, endIndex, contextualElement) {
    var single = startIndex === endIndex;
    var start = this.childAtIndex(parent, startIndex);
    var end = single ? start : this.childAtIndex(parent, endIndex);
    return this.createMorph(parent, start, end, contextualElement);
  };

  prototype.createUnsafeMorphAt = function (parent, startIndex, endIndex, contextualElement) {
    var morph = this.createMorphAt(parent, startIndex, endIndex, contextualElement);
    morph.parseTextAsHTML = true;
    return morph;
  };

  prototype.insertMorphBefore = function (element, referenceChild, contextualElement) {
    var insertion = this.document.createComment('');
    element.insertBefore(insertion, referenceChild);
    return this.createMorph(element, insertion, insertion, contextualElement);
  };

  prototype.appendMorph = function (element, contextualElement) {
    var insertion = this.document.createComment('');
    element.appendChild(insertion);
    return this.createMorph(element, insertion, insertion, contextualElement);
  };

  prototype.insertBoundary = function (fragment, index) {
    // this will always be null or firstChild
    var child = index === null ? null : this.childAtIndex(fragment, index);
    this.insertBefore(fragment, this.createTextNode(''), child);
  };

  prototype.setMorphHTML = function (morph, html) {
    morph.setHTML(html);
  };

  prototype.parseHTML = function (html, contextualElement) {
    var childNodes;

    if (interiorNamespace(contextualElement) === _domHelperBuildHtmlDom.svgNamespace) {
      childNodes = buildSVGDOM(html, this);
    } else {
      var nodes = _domHelperBuildHtmlDom.buildHTMLDOM(html, contextualElement, this);
      if (detectOmittedStartTag(html, contextualElement)) {
        var node = nodes[0];
        while (node && node.nodeType !== 1) {
          node = node.nextSibling;
        }
        childNodes = node.childNodes;
      } else {
        childNodes = nodes;
      }
    }

    // Copy node list to a fragment.
    var fragment = this.document.createDocumentFragment();

    if (childNodes && childNodes.length > 0) {
      var currentNode = childNodes[0];

      // We prepend an <option> to <select> boxes to absorb any browser bugs
      // related to auto-select behavior. Skip past it.
      if (contextualElement.tagName === 'SELECT') {
        currentNode = currentNode.nextSibling;
      }

      while (currentNode) {
        var tempNode = currentNode;
        currentNode = currentNode.nextSibling;

        fragment.appendChild(tempNode);
      }
    }

    return fragment;
  };

  var nodeURL;
  var parsingNode;

  function installEnvironmentSpecificMethods(domHelper) {
    var protocol = browserProtocolForURL.call(domHelper, 'foobar:baz');

    // Test to see if our DOM implementation parses
    // and normalizes URLs.
    if (protocol === 'foobar:') {
      // Swap in the method that doesn't do this test now that
      // we know it works.
      domHelper.protocolForURL = browserProtocolForURL;
    } else if (typeof URL === 'object') {
      // URL globally provided, likely from FastBoot's sandbox
      nodeURL = URL;
      domHelper.protocolForURL = nodeProtocolForURL;
    } else if (typeof module === 'object' && typeof module.require === 'function') {
      // Otherwise, we need to fall back to our own URL parsing.
      // Global `require` is shadowed by Ember's loader so we have to use the fully
      // qualified `module.require`.
      nodeURL = module.require('url');
      domHelper.protocolForURL = nodeProtocolForURL;
    } else {
      throw new Error("DOM Helper could not find valid URL parsing mechanism");
    }

    // A SimpleDOM-specific extension that allows us to place HTML directly
    // into the DOM tree, for when the output target is always serialized HTML.
    if (domHelper.document.createRawHTMLSection) {
      domHelper.setMorphHTML = nodeSetMorphHTML;
    }
  }

  function nodeSetMorphHTML(morph, html) {
    var section = this.document.createRawHTMLSection(html);
    morph.setNode(section);
  }

  function browserProtocolForURL(url) {
    if (!parsingNode) {
      parsingNode = this.document.createElement('a');
    }

    parsingNode.href = url;
    return parsingNode.protocol;
  }

  function nodeProtocolForURL(url) {
    var protocol = nodeURL.parse(url).protocol;
    return protocol === null ? ':' : protocol;
  }

  exports.default = DOMHelper;
});
enifed('ember-application/system/application-instance', ['exports', 'ember-metal/debug', 'ember-metal/features', 'ember-metal/property_get', 'ember-metal/property_set', 'ember-runtime/system/object', 'ember-metal/run_loop', 'ember-metal/computed', 'ember-runtime/mixins/container_proxy', 'ember-htmlbars/system/dom-helper', 'container/registry', 'ember-runtime/mixins/registry_proxy', 'ember-metal-views/renderer', 'ember-metal/assign', 'ember-metal/environment', 'ember-runtime/ext/rsvp', 'ember-views/system/jquery'], function (exports, _emberMetalDebug, _emberMetalFeatures, _emberMetalProperty_get, _emberMetalProperty_set, _emberRuntimeSystemObject, _emberMetalRun_loop, _emberMetalComputed, _emberRuntimeMixinsContainer_proxy, _emberHtmlbarsSystemDomHelper, _containerRegistry, _emberRuntimeMixinsRegistry_proxy, _emberMetalViewsRenderer, _emberMetalAssign, _emberMetalEnvironment, _emberRuntimeExtRsvp, _emberViewsSystemJquery) {
  /**
  @module ember
  @submodule ember-application
  */

  'use strict';

  var BootOptions = undefined;

  /**
    The `ApplicationInstance` encapsulates all of the stateful aspects of a
    running `Application`.
  
    At a high-level, we break application boot into two distinct phases:
  
    * Definition time, where all of the classes, templates, and other
      dependencies are loaded (typically in the browser).
    * Run time, where we begin executing the application once everything
      has loaded.
  
    Definition time can be expensive and only needs to happen once since it is
    an idempotent operation. For example, between test runs and FastBoot
    requests, the application stays the same. It is only the state that we want
    to reset.
  
    That state is what the `ApplicationInstance` manages: it is responsible for
    creating the container that contains all application state, and disposing of
    it once the particular test run or FastBoot request has finished.
  
    @public
    @class Ember.ApplicationInstance
    @extends Ember.Object
    @uses RegistryProxyMixin
    @uses ContainerProxyMixin
  */

  var ApplicationInstance = _emberRuntimeSystemObject.default.extend(_emberRuntimeMixinsRegistry_proxy.default, _emberRuntimeMixinsContainer_proxy.default, {
    /**
      The `Application` for which this is an instance.
       @property {Ember.Application} application
      @private
    */
    application: null,

    /**
      The DOM events for which the event dispatcher should listen.
       By default, the application's `Ember.EventDispatcher` listens
      for a set of standard DOM events, such as `mousedown` and
      `keyup`, and delegates them to your application's `Ember.View`
      instances.
       @private
      @property {Object} customEvents
    */
    customEvents: null,

    /**
      The root DOM element of the Application as an element or a
      [jQuery-compatible selector
      string](http://api.jquery.com/category/selectors/).
       @private
      @property {String|DOMElement} rootElement
    */
    rootElement: null,

    init: function () {
      this._super.apply(this, arguments);

      var application = _emberMetalProperty_get.get(this, 'application');

      // Create a per-instance registry that will use the application's registry
      // as a fallback for resolving registrations.
      var applicationRegistry = _emberMetalProperty_get.get(application, '__registry__');
      var registry = this.__registry__ = new _containerRegistry.default({
        fallback: applicationRegistry
      });

      // Create a per-instance container from the instance's registry
      this.__container__ = registry.container({ owner: this });

      // Register this instance in the per-instance registry.
      //
      // Why do we need to register the instance in the first place?
      // Because we need a good way for the root route (a.k.a ApplicationRoute)
      // to notify us when it has created the root-most view. That view is then
      // appended to the rootElement, in the case of apps, to the fixture harness
      // in tests, or rendered to a string in the case of FastBoot.
      this.register('-application-instance:main', this, { instantiate: false });

      this._booted = false;
    },

    /**
      Initialize the `Ember.ApplicationInstance` and return a promise that resolves
      with the instance itself when the boot process is complete.
       The primary task here is to run any registered instance initializers.
       See the documentation on `BootOptions` for the options it takes.
       @private
      @method boot
      @param options
      @return {Promise<Ember.ApplicationInstance,Error>}
    */
    boot: function () {
      var _this = this;

      var options = arguments.length <= 0 || arguments[0] === undefined ? {} : arguments[0];

      if (this._bootPromise) {
        return this._bootPromise;
      }

      this._bootPromise = new _emberRuntimeExtRsvp.default.Promise(function (resolve) {
        return resolve(_this._bootSync(options));
      });

      return this._bootPromise;
    },

    /**
      Unfortunately, a lot of existing code assumes booting an instance is
      synchronous â€“ specifically, a lot of tests assumes the last call to
      `app.advanceReadiness()` or `app.reset()` will result in a new instance
      being fully-booted when the current runloop completes.
       We would like new code (like the `visit` API) to stop making this assumption,
      so we created the asynchronous version above that returns a promise. But until
      we have migrated all the code, we would have to expose this method for use
      *internally* in places where we need to boot an instance synchronously.
       @private
    */
    _bootSync: function (options) {
      if (this._booted) {
        return this;
      }

      options = new BootOptions(options);

      var registry = this.__registry__;

      registry.register('-environment:main', options.toEnvironment(), { instantiate: false });
      registry.injection('view', '_environment', '-environment:main');
      registry.injection('route', '_environment', '-environment:main');

      registry.register('renderer:-dom', {
        create: function () {
          return new _emberMetalViewsRenderer.default(new _emberHtmlbarsSystemDomHelper.default(options.document), options.isInteractive);
        }
      });

      if (options.rootElement) {
        this.rootElement = options.rootElement;
      } else {
        this.rootElement = this.application.rootElement;
      }

      if (options.location) {
        var router = _emberMetalProperty_get.get(this, 'router');
        _emberMetalProperty_set.set(router, 'location', options.location);
      }

      this.application.runInstanceInitializers(this);

      if (options.isInteractive) {
        this.setupEventDispatcher();
      }

      this._booted = true;

      return this;
    },

    router: _emberMetalComputed.computed(function () {
      return this.lookup('router:main');
    }).readOnly(),

    /**
      This hook is called by the root-most Route (a.k.a. the ApplicationRoute)
      when it has finished creating the root View. By default, we simply take the
      view and append it to the `rootElement` specified on the Application.
       In cases like FastBoot and testing, we can override this hook and implement
      custom behavior, such as serializing to a string and sending over an HTTP
      socket rather than appending to DOM.
       @param view {Ember.View} the root-most view
      @private
    */
    didCreateRootView: function (view) {
      view.appendTo(this.rootElement);
    },

    /**
      Tells the router to start routing. The router will ask the location for the
      current URL of the page to determine the initial URL to start routing to.
      To start the app at a specific URL, call `handleURL` instead.
       @private
    */
    startRouting: function () {
      var router = _emberMetalProperty_get.get(this, 'router');
      router.startRouting(isResolverModuleBased(this));
      this._didSetupRouter = true;
    },

    /**
      @private
       Sets up the router, initializing the child router and configuring the
      location before routing begins.
       Because setup should only occur once, multiple calls to `setupRouter`
      beyond the first call have no effect.
    */
    setupRouter: function () {
      if (this._didSetupRouter) {
        return;
      }
      this._didSetupRouter = true;

      var router = _emberMetalProperty_get.get(this, 'router');
      router.setupRouter(isResolverModuleBased(this));
    },

    /**
      Directs the router to route to a particular URL. This is useful in tests,
      for example, to tell the app to start at a particular URL.
       @param url {String} the URL the router should route to
      @private
    */
    handleURL: function (url) {
      var router = _emberMetalProperty_get.get(this, 'router');

      this.setupRouter();
      return router.handleURL(url);
    },

    /**
      @private
    */
    setupEventDispatcher: function () {
      var dispatcher = this.lookup('event_dispatcher:main');
      var applicationCustomEvents = _emberMetalProperty_get.get(this.application, 'customEvents');
      var instanceCustomEvents = _emberMetalProperty_get.get(this, 'customEvents');

      var customEvents = _emberMetalAssign.default({}, applicationCustomEvents, instanceCustomEvents);
      dispatcher.setup(customEvents, this.rootElement);

      return dispatcher;
    },

    /**
      @private
    */
    willDestroy: function () {
      this._super.apply(this, arguments);
      _emberMetalRun_loop.default(this.__container__, 'destroy');
    },

    /**
     Unregister a factory.
      Overrides `RegistryProxy#unregister` in order to clear any cached instances
     of the unregistered factory.
      @public
     @method unregister
     @param {String} fullName
     */
    unregister: function (fullName) {
      this.__container__.reset(fullName);
      this._super.apply(this, arguments);
    }
  });

  ApplicationInstance.reopen({
    /**
      Returns the current URL of the app instance. This is useful when your
      app does not update the browsers URL bar (i.e. it uses the `'none'`
      location adapter).
       @public
      @return {String} the current URL
    */
    getURL: function () {
      var router = _emberMetalProperty_get.get(this, 'router');
      return _emberMetalProperty_get.get(router, 'url');
    },

    // `instance.visit(url)` should eventually replace `instance.handleURL()`;
    // the test helpers can probably be switched to use this implementation too

    /**
      Navigate the instance to a particular URL. This is useful in tests, for
      example, or to tell the app to start at a particular URL. This method
      returns a promise that resolves with the app instance when the transition
      is complete, or rejects if the transion was aborted due to an error.
       @public
      @param url {String} the destination URL
      @return {Promise}
    */
    visit: function (url) {
      var _this2 = this;

      this.setupRouter();

      var router = _emberMetalProperty_get.get(this, 'router');

      var handleResolve = function () {
        // Resolve only after rendering is complete
        return new _emberRuntimeExtRsvp.default.Promise(function (resolve) {
          // TODO: why is this necessary? Shouldn't 'actions' queue be enough?
          // Also, aren't proimses supposed to be async anyway?
          _emberMetalRun_loop.default.next(null, resolve, _this2);
        });
      };

      var handleReject = function (error) {
        if (error.error) {
          throw error.error;
        } else if (error.name === 'TransitionAborted' && router.router.activeTransition) {
          return router.router.activeTransition.then(handleResolve, handleReject);
        } else if (error.name === 'TransitionAborted') {
          throw new Error(error.message);
        } else {
          throw error;
        }
      };

      // Keeps the location adapter's internal URL in-sync
      _emberMetalProperty_get.get(router, 'location').setURL(url);

      return router.handleURL(url).then(handleResolve, handleReject);
    }
  });

  /**
    A list of boot-time configuration options for customizing the behavior of
    an `Ember.ApplicationInstance`.
     This is an interface class that exists purely to document the available
    options; you do not need to construct it manually. Simply pass a regular
    JavaScript object containing the desired options into methods that require
    one of these options object:
     ```javascript
    MyApp.visit("/", { location: "none", rootElement: "#container" });
    ```
     Not all combinations of the supported options are valid. See the documentation
    on `Ember.Application#visit` for the supported configurations.
     Internal, experimental or otherwise unstable flags are marked as private.
     @class BootOptions
    @namespace Ember.ApplicationInstance
    @public
  */
  BootOptions = function BootOptions() {
    var options = arguments.length <= 0 || arguments[0] === undefined ? {} : arguments[0];

    /**
      Provide a specific instance of jQuery. This is useful in conjunction with
      the `document` option, as it allows you to use a copy of `jQuery` that is
      appropriately bound to the foreign `document` (e.g. a jsdom).
       This is highly experimental and support very incomplete at the moment.
       @property jQuery
      @type Object
      @default auto-detected
      @private
    */
    this.jQuery = _emberViewsSystemJquery.default; // This default is overridable below

    /**
      Interactive mode: whether we need to set up event delegation and invoke
      lifecycle callbacks on Components.
       @property isInteractive
      @type boolean
      @default auto-detected
      @private
    */
    this.isInteractive = _emberMetalEnvironment.default.hasDOM; // This default is overridable below

    /**
      Run in a full browser environment.
       When this flag is set to `false`, it will disable most browser-specific
      and interactive features. Specifically:
       * It does not use `jQuery` to append the root view; the `rootElement`
        (either specified as a subsequent option or on the application itself)
        must already be an `Element` in the given `document` (as opposed to a
        string selector).
       * It does not set up an `EventDispatcher`.
       * It does not run any `Component` lifecycle hooks (such as `didInsertElement`).
       * It sets the `location` option to `"none"`. (If you would like to use
        the location adapter specified in the app's router instead, you can also
        specify `{ location: null }` to specifically opt-out.)
       @property isBrowser
      @type boolean
      @default auto-detected
      @public
    */
    if (options.isBrowser !== undefined) {
      this.isBrowser = !!options.isBrowser;
    } else {
      this.isBrowser = _emberMetalEnvironment.default.hasDOM;
    }

    if (!this.isBrowser) {
      this.jQuery = null;
      this.isInteractive = false;
      this.location = 'none';
    }

    /**
      Disable rendering completely.
       When this flag is set to `true`, it will disable the entire rendering
      pipeline. Essentially, this puts the app into "routing-only" mode. No
      templates will be rendered, and no Components will be created.
       @property shouldRender
      @type boolean
      @default true
      @public
    */
    if (options.shouldRender !== undefined) {
      this.shouldRender = !!options.shouldRender;
    } else {
      this.shouldRender = true;
    }

    if (!this.shouldRender) {
      this.jQuery = null;
      this.isInteractive = false;
    }

    /**
      If present, render into the given `Document` object instead of the
      global `window.document` object.
       In practice, this is only useful in non-browser environment or in
      non-interactive mode, because Ember's `jQuery` dependency is
      implicitly bound to the current document, causing event delegation
      to not work properly when the app is rendered into a foreign
      document object (such as an iframe's `contentDocument`).
       In non-browser mode, this could be a "`Document`-like" object as
      Ember only interact with a small subset of the DOM API in non-
      interactive mode. While the exact requirements have not yet been
      formalized, the `SimpleDOM` library's implementation is known to
      work.
       @property document
      @type Document
      @default the global `document` object
      @public
    */
    if (options.document) {
      this.document = options.document;
    } else {
      this.document = typeof document !== 'undefined' ? document : null;
    }

    /**
      If present, overrides the application's `rootElement` property on
      the instance. This is useful for testing environment, where you
      might want to append the root view to a fixture area.
       In non-browser mode, because Ember does not have access to jQuery,
      this options must be specified as a DOM `Element` object instead of
      a selector string.
       See the documentation on `Ember.Applications`'s `rootElement` for
      details.
       @property rootElement
      @type String|Element
      @default null
      @public
     */
    if (options.rootElement) {
      this.rootElement = options.rootElement;
    }

    // Set these options last to give the user a chance to override the
    // defaults from the "combo" options like `isBrowser` (although in
    // practice, the resulting combination is probably invalid)

    /**
      If present, overrides the router's `location` property with this
      value. This is useful for environments where trying to modify the
      URL would be inappropriate.
       @property location
      @type string
      @default null
      @public
    */
    if (options.location !== undefined) {
      this.location = options.location;
    }

    if (options.jQuery !== undefined) {
      this.jQuery = options.jQuery;
    }

    if (options.isInteractive !== undefined) {
      this.isInteractive = !!options.isInteractive;
    }
  };

  BootOptions.prototype.toEnvironment = function () {
    var env = _emberMetalAssign.default({}, _emberMetalEnvironment.default);
    // For compatibility with existing code
    env.hasDOM = this.isBrowser;
    env.options = this;
    return env;
  };

  function isResolverModuleBased(applicationInstance) {
    return !!applicationInstance.application.__registry__.resolver.moduleBasedResolver;
  }

  Object.defineProperty(ApplicationInstance.prototype, 'container', {
    configurable: true,
    enumerable: false,
    get: function () {
      var instance = this;
      return {
        lookup: function () {
          _emberMetalDebug.deprecate('Using `ApplicationInstance.container.lookup` is deprecated. Please use `ApplicationInstance.lookup` instead.', false, {
            id: 'ember-application.app-instance-container',
            until: '3.0.0',
            url: 'http://emberjs.com/deprecations/v2.x/#toc_ember-applicationinstance-container'
          });
          return instance.lookup.apply(instance, arguments);
        }
      };
    }
  });

  Object.defineProperty(ApplicationInstance.prototype, 'registry', {
    configurable: true,
    enumerable: false,
    get: function () {
      return _emberRuntimeMixinsRegistry_proxy.buildFakeRegistryWithDeprecations(this, 'ApplicationInstance');
    }
  });

  exports.default = ApplicationInstance;
});
enifed('ember-application/system/application', ['exports', 'dag-map', 'container/registry', 'ember-metal', 'ember-metal/debug', 'ember-metal/features', 'ember-metal/property_get', 'ember-metal/property_set', 'ember-metal/empty_object', 'ember-runtime/system/lazy_load', 'ember-runtime/system/namespace', 'ember-application/system/resolver', 'ember-metal/run_loop', 'ember-metal/utils', 'ember-runtime/controllers/controller', 'ember-metal-views/renderer', 'ember-htmlbars/system/dom-helper', 'ember-views/views/select', 'ember-routing-views/views/outlet', 'ember-views/views/view', 'ember-views/system/event_dispatcher', 'ember-views/system/jquery', 'ember-routing/system/route', 'ember-routing/system/router', 'ember-routing/location/hash_location', 'ember-routing/location/history_location', 'ember-routing/location/auto_location', 'ember-routing/location/none_location', 'ember-routing/system/cache', 'ember-application/system/application-instance', 'ember-views/views/text_field', 'ember-views/views/text_area', 'ember-views/views/checkbox', 'ember-views/views/legacy_each_view', 'ember-routing-views/components/link-to', 'ember-routing/services/routing', 'ember-extension-support/container_debug_adapter', 'ember-runtime/mixins/registry_proxy', 'ember-metal/environment', 'ember-runtime/ext/rsvp'], function (exports, _dagMap, _containerRegistry, _emberMetal, _emberMetalDebug, _emberMetalFeatures, _emberMetalProperty_get, _emberMetalProperty_set, _emberMetalEmpty_object, _emberRuntimeSystemLazy_load, _emberRuntimeSystemNamespace, _emberApplicationSystemResolver, _emberMetalRun_loop, _emberMetalUtils, _emberRuntimeControllersController, _emberMetalViewsRenderer, _emberHtmlbarsSystemDomHelper, _emberViewsViewsSelect, _emberRoutingViewsViewsOutlet, _emberViewsViewsView, _emberViewsSystemEvent_dispatcher, _emberViewsSystemJquery, _emberRoutingSystemRoute, _emberRoutingSystemRouter, _emberRoutingLocationHash_location, _emberRoutingLocationHistory_location, _emberRoutingLocationAuto_location, _emberRoutingLocationNone_location, _emberRoutingSystemCache, _emberApplicationSystemApplicationInstance, _emberViewsViewsText_field, _emberViewsViewsText_area, _emberViewsViewsCheckbox, _emberViewsViewsLegacy_each_view, _emberRoutingViewsComponentsLinkTo, _emberRoutingServicesRouting, _emberExtensionSupportContainer_debug_adapter, _emberRuntimeMixinsRegistry_proxy, _emberMetalEnvironment, _emberRuntimeExtRsvp) {
  /**
  @module ember
  @submodule ember-application
  */
  'use strict';

  function props(obj) {
    var properties = [];

    for (var key in obj) {
      properties.push(key);
    }

    return properties;
  }

  var librariesRegistered = false;

  /**
    An instance of `Ember.Application` is the starting point for every Ember
    application. It helps to instantiate, initialize and coordinate the many
    objects that make up your app.
  
    Each Ember app has one and only one `Ember.Application` object. In fact, the
    very first thing you should do in your application is create the instance:
  
    ```javascript
    window.App = Ember.Application.create();
    ```
  
    Typically, the application object is the only global variable. All other
    classes in your app should be properties on the `Ember.Application` instance,
    which highlights its first role: a global namespace.
  
    For example, if you define a view class, it might look like this:
  
    ```javascript
    App.MyView = Ember.View.extend();
    ```
  
    By default, calling `Ember.Application.create()` will automatically initialize
    your application by calling the `Ember.Application.initialize()` method. If
    you need to delay initialization, you can call your app's `deferReadiness()`
    method. When you are ready for your app to be initialized, call its
    `advanceReadiness()` method.
  
    You can define a `ready` method on the `Ember.Application` instance, which
    will be run by Ember when the application is initialized.
  
    Because `Ember.Application` inherits from `Ember.Namespace`, any classes
    you create will have useful string representations when calling `toString()`.
    See the `Ember.Namespace` documentation for more information.
  
    While you can think of your `Ember.Application` as a container that holds the
    other classes in your application, there are several other responsibilities
    going on under-the-hood that you may want to understand.
  
    ### Event Delegation
  
    Ember uses a technique called _event delegation_. This allows the framework
    to set up a global, shared event listener instead of requiring each view to
    do it manually. For example, instead of each view registering its own
    `mousedown` listener on its associated element, Ember sets up a `mousedown`
    listener on the `body`.
  
    If a `mousedown` event occurs, Ember will look at the target of the event and
    start walking up the DOM node tree, finding corresponding views and invoking
    their `mouseDown` method as it goes.
  
    `Ember.Application` has a number of default events that it listens for, as
    well as a mapping from lowercase events to camel-cased view method names. For
    example, the `keypress` event causes the `keyPress` method on the view to be
    called, the `dblclick` event causes `doubleClick` to be called, and so on.
  
    If there is a bubbling browser event that Ember does not listen for by
    default, you can specify custom events and their corresponding view method
    names by setting the application's `customEvents` property:
  
    ```javascript
    var App = Ember.Application.create({
      customEvents: {
        // add support for the paste event
        paste: 'paste'
      }
    });
    ```
  
    To prevent Ember from setting up a listener for a default event,
    specify the event name with a `null` value in the `customEvents`
    property:
  
    ```javascript
    var App = Ember.Application.create({
      customEvents: {
        // prevent listeners for mouseenter/mouseleave events
        mouseenter: null,
        mouseleave: null
      }
    });
    ```
  
    By default, the application sets up these event listeners on the document
    body. However, in cases where you are embedding an Ember application inside
    an existing page, you may want it to set up the listeners on an element
    inside the body.
  
    For example, if only events inside a DOM element with the ID of `ember-app`
    should be delegated, set your application's `rootElement` property:
  
    ```javascript
    var App = Ember.Application.create({
      rootElement: '#ember-app'
    });
    ```
  
    The `rootElement` can be either a DOM element or a jQuery-compatible selector
    string. Note that *views appended to the DOM outside the root element will
    not receive events.* If you specify a custom root element, make sure you only
    append views inside it!
  
    To learn more about the advantages of event delegation and the Ember view
    layer, and a list of the event listeners that are setup by default, visit the
    [Ember View Layer guide](http://emberjs.com/guides/understanding-ember/the-view-layer/#toc_event-delegation).
  
    ### Initializers
  
    Libraries on top of Ember can add initializers, like so:
  
    ```javascript
    Ember.Application.initializer({
      name: 'api-adapter',
  
      initialize: function(application) {
        application.register('api-adapter:main', ApiAdapter);
      }
    });
    ```
  
    Initializers provide an opportunity to access the internal registry, which
    organizes the different components of an Ember application. Additionally
    they provide a chance to access the instantiated application. Beyond
    being used for libraries, initializers are also a great way to organize
    dependency injection or setup in your own application.
  
    ### Routing
  
    In addition to creating your application's router, `Ember.Application` is
    also responsible for telling the router when to start routing. Transitions
    between routes can be logged with the `LOG_TRANSITIONS` flag, and more
    detailed intra-transition logging can be logged with
    the `LOG_TRANSITIONS_INTERNAL` flag:
  
    ```javascript
    var App = Ember.Application.create({
      LOG_TRANSITIONS: true, // basic logging of successful transitions
      LOG_TRANSITIONS_INTERNAL: true // detailed logging of all routing steps
    });
    ```
  
    By default, the router will begin trying to translate the current URL into
    application state once the browser emits the `DOMContentReady` event. If you
    need to defer routing, you can call the application's `deferReadiness()`
    method. Once routing can begin, call the `advanceReadiness()` method.
  
    If there is any setup required before routing begins, you can implement a
    `ready()` method on your app that will be invoked immediately before routing
    begins.
  
    @class Application
    @namespace Ember
    @extends Ember.Namespace
    @uses RegistryProxyMixin
    @public
  */

  var Application = _emberRuntimeSystemNamespace.default.extend(_emberRuntimeMixinsRegistry_proxy.default, {
    _suppressDeferredDeprecation: true,

    /**
      The root DOM element of the Application. This can be specified as an
      element or a
      [jQuery-compatible selector string](http://api.jquery.com/category/selectors/).
       This is the element that will be passed to the Application's,
      `eventDispatcher`, which sets up the listeners for event delegation. Every
      view in your application should be a child of the element you specify here.
       @property rootElement
      @type DOMElement
      @default 'body'
      @public
    */
    rootElement: 'body',

    /**
      The `Ember.EventDispatcher` responsible for delegating events to this
      application's views.
       The event dispatcher is created by the application at initialization time
      and sets up event listeners on the DOM element described by the
      application's `rootElement` property.
       See the documentation for `Ember.EventDispatcher` for more information.
       @property eventDispatcher
      @type Ember.EventDispatcher
      @default null
      @public
    */
    eventDispatcher: null,

    /**
      The DOM events for which the event dispatcher should listen.
       By default, the application's `Ember.EventDispatcher` listens
      for a set of standard DOM events, such as `mousedown` and
      `keyup`, and delegates them to your application's `Ember.View`
      instances.
       If you would like additional bubbling events to be delegated to your
      views, set your `Ember.Application`'s `customEvents` property
      to a hash containing the DOM event name as the key and the
      corresponding view method name as the value. Setting an event to
      a value of `null` will prevent a default event listener from being
      added for that event.
       To add new events to be listened to:
       ```javascript
      var App = Ember.Application.create({
        customEvents: {
          // add support for the paste event
          paste: 'paste'
        }
      });
      ```
       To prevent default events from being listened to:
       ```javascript
      var App = Ember.Application.create({
        customEvents: {
          // remove support for mouseenter / mouseleave events
          mouseenter: null,
          mouseleave: null
        }
      });
      ```
      @property customEvents
      @type Object
      @default null
      @public
    */
    customEvents: null,

    /**
      Whether the application should automatically start routing and render
      templates to the `rootElement` on DOM ready. While default by true,
      other environments such as FastBoot or a testing harness can set this
      property to `false` and control the precise timing and behavior of the boot
      process.
       @property autoboot
      @type Boolean
      @default true
      @private
    */
    autoboot: true,

    /**
      Whether the application should be configured for the legacy "globals mode".
      Under this mode, the Application object serves as a global namespace for all
      classes.
       ```javascript
      var App = Ember.Application.create({
        ...
      });
       App.Router.reopen({
        location: 'none'
      });
       App.Router.map({
        ...
      });
       App.MyComponent = Ember.Component.extend({
        ...
      });
      ```
       This flag also exposes other internal APIs that assumes the existence of
      a special "default instance", like `App.__container__.lookup(...)`.
       This option is currently not configurable, its value is derived from
      the `autoboot` flag â€“ disabling `autoboot` also implies opting-out of
      globals mode support, although they are ultimately orthogonal concerns.
       Some of the global modes features are already deprecated in 1.x. The
      existence of this flag is to untangle the globals mode code paths from
      the autoboot code paths, so that these legacy features can be reviewed
      for deprecation/removal separately.
       Forcing the (autoboot=true, _globalsMode=false) here and running the tests
      would reveal all the places where we are still relying on these legacy
      behavior internally (mostly just tests).
       @property _globalsMode
      @type Boolean
      @default true
      @private
    */
    _globalsMode: true,

    init: function () {
      this._super.apply(this, arguments);

      if (!this.$) {
        this.$ = _emberViewsSystemJquery.default;
      }

      this.buildRegistry();

      registerLibraries();
      logLibraryVersions();

      // Start off the number of deferrals at 1. This will be decremented by
      // the Application's own `boot` method.
      this._readinessDeferrals = 1;
      this._booted = false;

      this.autoboot = this._globalsMode = !!this.autoboot;

      if (this._globalsMode) {
        this._prepareForGlobalsMode();
      }

      if (this.autoboot) {
        this.waitForDOMReady();
      }
    },

    /**
      Build and configure the registry for the current application.
       @private
      @method buildRegistry
      @return {Ember.Registry} the configured registry
    */
    buildRegistry: function () {
      var registry = this.__registry__ = Application.buildRegistry(this);

      return registry;
    },

    /**
      Create an ApplicationInstance for this application.
       @private
      @method buildInstance
      @return {Ember.ApplicationInstance} the application instance
    */
    buildInstance: function () {
      var options = arguments.length <= 0 || arguments[0] === undefined ? {} : arguments[0];

      options.application = this;
      return _emberApplicationSystemApplicationInstance.default.create(options);
    },

    /**
      Enable the legacy globals mode by allowing this application to act
      as a global namespace. See the docs on the `_globalsMode` property
      for details.
       Most of these features are already deprecated in 1.x, so we can
      stop using them internally and try to remove them.
       @private
      @method _prepareForGlobalsMode
    */
    _prepareForGlobalsMode: function () {
      // Create subclass of Ember.Router for this Application instance.
      // This is to ensure that someone reopening `App.Router` does not
      // tamper with the default `Ember.Router`.
      this.Router = (this.Router || _emberRoutingSystemRouter.default).extend();

      this._buildDeprecatedInstance();
    },

    /*
      Build the deprecated instance for legacy globals mode support.
      Called when creating and resetting the application.
       This is orthogonal to autoboot: the deprecated instance needs to
      be created at Application construction (not boot) time to expose
      App.__container__ and the global Ember.View.views registry. If
      autoboot sees that this instance exists, it will continue booting
      it to avoid doing unncessary work (as opposed to building a new
      instance at boot time), but they are otherwise unrelated.
       @private
      @method _buildDeprecatedInstance
    */
    _buildDeprecatedInstance: function () {
      // Build a default instance
      var instance = this.buildInstance();

      // Legacy support for App.__container__ and other global methods
      // on App that rely on a single, default instance.
      this.__deprecatedInstance__ = instance;
      this.__container__ = instance.__container__;

      // For the default instance only, set the view registry to the global
      // Ember.View.views hash for backwards-compatibility.
      _emberViewsViewsView.default.views = instance.lookup('-view-registry:main');
    },

    /**
      Automatically kick-off the boot process for the application once the
      DOM has become ready.
       The initialization itself is scheduled on the actions queue which
      ensures that code-loading finishes before booting.
       If you are asynchronously loading code, you should call `deferReadiness()`
      to defer booting, and then call `advanceReadiness()` once all of your code
      has finished loading.
       @private
      @method waitForDOMReady
    */
    waitForDOMReady: function () {
      if (!this.$ || this.$.isReady) {
        _emberMetalRun_loop.default.schedule('actions', this, 'domReady');
      } else {
        this.$().ready(_emberMetalRun_loop.default.bind(this, 'domReady'));
      }
    },

    /**
      This is the autoboot flow:
       1. Boot the app by calling `this.boot()`
      2. Create an instance (or use the `__deprecatedInstance__` in globals mode)
      3. Boot the instance by calling `instance.boot()`
      4. Invoke the `App.ready()` callback
      5. Kick-off routing on the instance
       Ideally, this is all we would need to do:
       ```javascript
      _autoBoot() {
        this.boot().then(() => {
          let instance = (this._globalsMode) ? this.__deprecatedInstance__ : this.buildInstance();
          return instance.boot();
        }).then((instance) => {
          App.ready();
          instance.startRouting();
        });
      }
      ```
       Unfortunately, we cannot actually write this because we need to participate
      in the "synchronous" boot process. While the code above would work fine on
      the initial boot (i.e. DOM ready), when `App.reset()` is called, we need to
      boot a new instance synchronously (see the documentation on `_bootSync()`
      for details).
       Because of this restriction, the actual logic of this method is located
      inside `didBecomeReady()`.
       @private
      @method domReady
    */
    domReady: function () {
      if (this.isDestroyed) {
        return;
      }

      this._bootSync();

      // Continues to `didBecomeReady`
    },

    /**
      Use this to defer readiness until some condition is true.
       Example:
       ```javascript
      var App = Ember.Application.create();
       App.deferReadiness();
       // Ember.$ is a reference to the jQuery object/function
      Ember.$.getJSON('/auth-token', function(token) {
        App.token = token;
        App.advanceReadiness();
      });
      ```
       This allows you to perform asynchronous setup logic and defer
      booting your application until the setup has finished.
       However, if the setup requires a loading UI, it might be better
      to use the router for this purpose.
       @method deferReadiness
      @public
    */
    deferReadiness: function () {
      _emberMetalDebug.assert('You must call deferReadiness on an instance of Ember.Application', this instanceof Application);
      _emberMetalDebug.assert('You cannot defer readiness since the `ready()` hook has already been called.', this._readinessDeferrals > 0);
      this._readinessDeferrals++;
    },

    /**
      Call `advanceReadiness` after any asynchronous setup logic has completed.
      Each call to `deferReadiness` must be matched by a call to `advanceReadiness`
      or the application will never become ready and routing will not begin.
       @method advanceReadiness
      @see {Ember.Application#deferReadiness}
      @public
    */
    advanceReadiness: function () {
      _emberMetalDebug.assert('You must call advanceReadiness on an instance of Ember.Application', this instanceof Application);
      this._readinessDeferrals--;

      if (this._readinessDeferrals === 0) {
        _emberMetalRun_loop.default.once(this, this.didBecomeReady);
      }
    },

    /**
      Initialize the application and return a promise that resolves with the `Ember.Application`
      object when the boot process is complete.
       Run any application initializers and run the application load hook. These hooks may
      choose to defer readiness. For example, an authentication hook might want to defer
      readiness until the auth token has been retrieved.
       By default, this method is called automatically on "DOM ready"; however, if autoboot
      is disabled, this is automatically called when the first application instance is
      created via `visit`.
       @private
      @method boot
      @return {Promise<Ember.Application,Error>}
    */
    boot: function () {
      if (this._bootPromise) {
        return this._bootPromise;
      }

      try {
        this._bootSync();
      } catch (_) {
        // Ignore th error: in the asynchronous boot path, the error is already reflected
        // in the promise rejection
      }

      return this._bootPromise;
    },

    /**
      Unfortunately, a lot of existing code assumes the booting process is
      "synchronous". Specifically, a lot of tests assumes the last call to
      `app.advanceReadiness()` or `app.reset()` will result in the app being
      fully-booted when the current runloop completes.
       We would like new code (like the `visit` API) to stop making this assumption,
      so we created the asynchronous version above that returns a promise. But until
      we have migrated all the code, we would have to expose this method for use
      *internally* in places where we need to boot an app "synchronously".
       @private
    */
    _bootSync: function () {
      if (this._booted) {
        return;
      }

      // Even though this returns synchronously, we still need to make sure the
      // boot promise exists for book-keeping purposes: if anything went wrong in
      // the boot process, we need to store the error as a rejection on the boot
      // promise so that a future caller of `boot()` can tell what failed.
      var defer = this._bootResolver = new _emberRuntimeExtRsvp.default.defer();
      this._bootPromise = defer.promise;

      try {
        this.runInitializers();
        _emberRuntimeSystemLazy_load.runLoadHooks('application', this);
        this.advanceReadiness();
        // Continues to `didBecomeReady`
      } catch (error) {
        // For the asynchronous boot path
        defer.reject(error);

        // For the synchronous boot path
        throw error;
      }
    },

    /**
      Reset the application. This is typically used only in tests. It cleans up
      the application in the following order:
       1. Deactivate existing routes
      2. Destroy all objects in the container
      3. Create a new application container
      4. Re-route to the existing url
       Typical Example:
       ```javascript
      var App;
       run(function() {
        App = Ember.Application.create();
      });
       module('acceptance test', {
        setup: function() {
          App.reset();
        }
      });
       test('first test', function() {
        // App is freshly reset
      });
       test('second test', function() {
        // App is again freshly reset
      });
      ```
       Advanced Example:
       Occasionally you may want to prevent the app from initializing during
      setup. This could enable extra configuration, or enable asserting prior
      to the app becoming ready.
       ```javascript
      var App;
       run(function() {
        App = Ember.Application.create();
      });
       module('acceptance test', {
        setup: function() {
          run(function() {
            App.reset();
            App.deferReadiness();
          });
        }
      });
       test('first test', function() {
        ok(true, 'something before app is initialized');
         run(function() {
          App.advanceReadiness();
        });
         ok(true, 'something after app is initialized');
      });
      ```
       @method reset
      @public
    */
    reset: function () {
      _emberMetalDebug.assert('Calling reset() on instances of `Ember.Application` is not\n            supported when globals mode is disabled; call `visit()` to\n            create new `Ember.ApplicationInstance`s and dispose them\n            via their `destroy()` method instead.', this._globalsMode && this.autoboot);

      var instance = this.__deprecatedInstance__;

      this._readinessDeferrals = 1;
      this._bootPromise = null;
      this._bootResolver = null;
      this._booted = false;

      function handleReset() {
        _emberMetalRun_loop.default(instance, 'destroy');
        this._buildDeprecatedInstance();
        _emberMetalRun_loop.default.schedule('actions', this, '_bootSync');
      }

      _emberMetalRun_loop.default.join(this, handleReset);
    },

    /**
      @private
      @method instanceInitializer
    */
    instanceInitializer: function (options) {
      this.constructor.instanceInitializer(options);
    },

    /**
      @private
      @method runInitializers
    */
    runInitializers: function () {
      var App = this;
      this._runInitializer('initializers', function (name, initializer) {
        _emberMetalDebug.assert('No application initializer named \'' + name + '\'', !!initializer);
        if (initializer.initialize.length === 2) {
          _emberMetalDebug.deprecate('The `initialize` method for Application initializer \'' + name + '\' should take only one argument - `App`, an instance of an `Application`.', false, {
            id: 'ember-application.app-initializer-initialize-arguments',
            until: '3.0.0',
            url: 'http://emberjs.com/deprecations/v2.x/#toc_initializer-arity'
          });

          initializer.initialize(App.__registry__, App);
        } else {
          initializer.initialize(App);
        }
      });
    },

    /**
      @private
      @since 1.12.0
      @method runInstanceInitializers
    */
    runInstanceInitializers: function (instance) {
      this._runInitializer('instanceInitializers', function (name, initializer) {
        _emberMetalDebug.assert('No instance initializer named \'' + name + '\'', !!initializer);
        initializer.initialize(instance);
      });
    },

    _runInitializer: function (bucketName, cb) {
      var initializersByName = _emberMetalProperty_get.get(this.constructor, bucketName);
      var initializers = props(initializersByName);
      var graph = new _dagMap.default();
      var initializer;

      for (var i = 0; i < initializers.length; i++) {
        initializer = initializersByName[initializers[i]];
        graph.addEdges(initializer.name, initializer, initializer.before, initializer.after);
      }

      graph.topsort(function (vertex) {
        cb(vertex.name, vertex.value);
      });
    },

    /**
      @private
      @method didBecomeReady
    */
    didBecomeReady: function () {
      try {
        // TODO: Is this still needed for _globalsMode = false?
        if (!_emberMetal.default.testing) {
          // Eagerly name all classes that are already loaded
          _emberMetal.default.Namespace.processAll();
          _emberMetal.default.BOOTED = true;
        }

        // See documentation on `_autoboot()` for details
        if (this.autoboot) {
          var instance = undefined;

          if (this._globalsMode) {
            // If we already have the __deprecatedInstance__ lying around, boot it to
            // avoid unnecessary work
            instance = this.__deprecatedInstance__;
          } else {
            // Otherwise, build an instance and boot it. This is currently unreachable,
            // because we forced _globalsMode to === autoboot; but having this branch
            // allows us to locally toggle that flag for weeding out legacy globals mode
            // dependencies independently
            instance = this.buildInstance();
          }

          instance._bootSync();

          // TODO: App.ready() is not called when autoboot is disabled, is this correct?
          this.ready();

          instance.startRouting();
        }

        // For the asynchronous boot path
        this._bootResolver.resolve(this);

        // For the synchronous boot path
        this._booted = true;
      } catch (error) {
        // For the asynchronous boot path
        this._bootResolver.reject(error);

        // For the synchronous boot path
        throw error;
      }
    },

    /**
      Called when the Application has become ready, immediately before routing
      begins. The call will be delayed until the DOM has become ready.
       @event ready
      @public
    */
    ready: function () {
      return this;
    },

    /**
      Set this to provide an alternate class to `Ember.DefaultResolver`
        @deprecated Use 'Resolver' instead
      @property resolver
      @public
    */
    resolver: null,

    /**
      Set this to provide an alternate class to `Ember.DefaultResolver`
       @property resolver
      @public
    */
    Resolver: null,

    // This method must be moved to the application instance object
    willDestroy: function () {
      this._super.apply(this, arguments);
      _emberMetal.default.BOOTED = false;
      this._booted = false;
      this._bootPromise = null;
      this._bootResolver = null;

      if (_emberRuntimeSystemLazy_load._loaded.application === this) {
        _emberRuntimeSystemLazy_load._loaded.application = undefined;
      }

      if (this._globalsMode && this.__deprecatedInstance__) {
        this.__deprecatedInstance__.destroy();
      }
    },

    initializer: function (options) {
      this.constructor.initializer(options);
    }
  });

  Object.defineProperty(Application.prototype, 'registry', {
    configurable: true,
    enumerable: false,
    get: function () {
      return _emberRuntimeMixinsRegistry_proxy.buildFakeRegistryWithDeprecations(this, 'Application');
    }
  });

  Application.reopenClass({
    /**
      Instance initializers run after all initializers have run. Because
      instance initializers run after the app is fully set up. We have access
      to the store, container, and other items. However, these initializers run
      after code has loaded and are not allowed to defer readiness.
       Instance initializer receives an object which has the following attributes:
      `name`, `before`, `after`, `initialize`. The only required attribute is
      `initialize`, all others are optional.
       * `name` allows you to specify under which name the instanceInitializer is
      registered. This must be a unique name, as trying to register two
      instanceInitializer with the same name will result in an error.
       ```javascript
      Ember.Application.instanceInitializer({
        name: 'namedinstanceInitializer',
         initialize: function(application) {
          Ember.debug('Running namedInitializer!');
        }
      });
      ```
       * `before` and `after` are used to ensure that this initializer is ran prior
      or after the one identified by the value. This value can be a single string
      or an array of strings, referencing the `name` of other initializers.
       * See Ember.Application.initializer for discussion on the usage of before
      and after.
       Example instanceInitializer to preload data into the store.
       ```javascript
      Ember.Application.initializer({
        name: 'preload-data',
         initialize: function(application) {
          var userConfig, userConfigEncoded, store;
          // We have a HTML escaped JSON representation of the user's basic
          // configuration generated server side and stored in the DOM of the main
          // index.html file. This allows the app to have access to a set of data
          // without making any additional remote calls. Good for basic data that is
          // needed for immediate rendering of the page. Keep in mind, this data,
          // like all local models and data can be manipulated by the user, so it
          // should not be relied upon for security or authorization.
          //
          // Grab the encoded data from the meta tag
          userConfigEncoded = Ember.$('head meta[name=app-user-config]').attr('content');
          // Unescape the text, then parse the resulting JSON into a real object
          userConfig = JSON.parse(unescape(userConfigEncoded));
          // Lookup the store
          store = application.lookup('service:store');
          // Push the encoded JSON into the store
          store.pushPayload(userConfig);
        }
      });
      ```
       @method instanceInitializer
      @param instanceInitializer
      @public
    */
    instanceInitializer: buildInitializerMethod('instanceInitializers', 'instance initializer')
  });

  Application.reopen({
    /**
      Boot a new instance of `Ember.ApplicationInstance` for the current
      application and navigate it to the given `url`. Returns a `Promise` that
      resolves with the instance when the initial routing and rendering is
      complete, or rejects with any error that occured during the boot process.
       When `autoboot` is disabled, calling `visit` would first cause the
      application to boot, which runs the application initializers.
       This method also takes a hash of boot-time configuration options for
      customizing the instance's behavior. See the documentation on
      `Ember.ApplicationInstance.BootOptions` for details.
       `Ember.ApplicationInstance.BootOptions` is an interface class that exists
      purely to document the available options; you do not need to construct it
      manually. Simply pass a regular JavaScript object containing of the
      desired options:
       ```javascript
      MyApp.visit("/", { location: "none", rootElement: "#container" });
      ```
       ### Supported Scenarios
       While the `BootOptions` class exposes a large number of knobs, not all
      combinations of them are valid; certain incompatible combinations might
      result in unexpected behavior.
       For example, booting the instance in the full browser environment
      while specifying a foriegn `document` object (e.g. `{ isBrowser: true,
      document: iframe.contentDocument }`) does not work correctly today,
      largely due to Ember's jQuery dependency.
       Currently, there are three officially supported scenarios/configurations.
      Usages outside of these scenarios are not guaranteed to work, but please
      feel free to file bug reports documenting your experience and any issues
      you encountered to help expand support.
       #### Browser Applications (Manual Boot)
       The setup is largely similar to how Ember works out-of-the-box. Normally,
      Ember will boot a default instance for your Application on "DOM ready".
      However, you can customize this behavior by disabling `autoboot`.
       For example, this allows you to render a miniture demo of your application
      into a specific area on your marketing website:
       ```javascript
      import MyApp from 'my-app';
       $(function() {
        let App = MyApp.create({ autoboot: false });
         let options = {
          // Override the router's location adapter to prevent it from updating
          // the URL in the address bar
          location: 'none',
           // Override the default `rootElement` on the app to render into a
          // specific `div` on the page
          rootElement: '#demo'
        };
         // Start the app at the special demo URL
        App.visit('/demo', options);
      });
      ````
       Or perhaps you might want to boot two instances of your app on the same
      page for a split-screen multiplayer experience:
       ```javascript
      import MyApp from 'my-app';
       $(function() {
        let App = MyApp.create({ autoboot: false });
         let sessionId = MyApp.generateSessionID();
         let player1 = App.visit(`/matches/join?name=Player+1&session=${sessionId}`, { rootElement: '#left', location: 'none' });
        let player2 = App.visit(`/matches/join?name=Player+2&session=${sessionId}`, { rootElement: '#right', location: 'none' });
         Promise.all([player1, player2]).then(() => {
          // Both apps have completed the initial render
          $('#loading').fadeOut();
        });
      });
      ```
       Do note that each app instance maintains their own registry/container, so
      they will run in complete isolation by default.
       #### Server-Side Rendering (also known as FastBoot)
       This setup allows you to run your Ember app in a server environment using
      Node.js and render its content into static HTML for SEO purposes.
       ```javascript
      const HTMLSerializer = new SimpleDOM.HTMLSerializer(SimpleDOM.voidMap);
       function renderURL(url) {
        let dom = new SimpleDOM.Document();
        let rootElement = dom.body;
        let options = { isBrowser: false, document: dom, rootElement: rootElement };
         return MyApp.visit(options).then(instance => {
          try {
            return HTMLSerializer.serialize(rootElement.firstChild);
          } finally {
            instance.destroy();
          }
        });
      }
      ```
       In this scenario, because Ember does not have access to a global `document`
      object in the Node.js environment, you must provide one explicitly. In practice,
      in the non-browser environment, the stand-in `document` object only need to
      implement a limited subset of the full DOM API. The `SimpleDOM` library is known
      to work.
       Since there is no access to jQuery in the non-browser environment, you must also
      specify a DOM `Element` object in the same `document` for the `rootElement` option
      (as opposed to a selector string like `"body"`).
       See the documentation on the `isBrowser`, `document` and `rootElement` properties
      on `Ember.ApplicationInstance.BootOptions` for details.
       #### Server-Side Resource Discovery
       This setup allows you to run the routing layer of your Ember app in a server
      environment using Node.js and completely disable rendering. This allows you
      to simulate and discover the resources (i.e. AJAX requests) needed to fufill
      a given request and eagerly "push" these resources to the client.
       ```app/initializers/network-service.js
      import BrowserNetworkService from 'app/services/network/browser';
      import NodeNetworkService from 'app/services/network/node';
       // Inject a (hypothetical) service for abstracting all AJAX calls and use
      // the appropiate implementaion on the client/server. This also allows the
      // server to log all the AJAX calls made during a particular request and use
      // that for resource-discovery purpose.
       export function initialize(application) {
        if (window) { // browser
          application.register('service:network', BrowserNetworkService);
        } else { // node
          application.register('service:network', NodeNetworkService);
        }
         application.inject('route', 'network', 'service:network');
      };
       export default {
        name: 'network-service',
        initialize: initialize
      };
      ```
       ```app/routes/post.js
      import Ember from 'ember';
       // An example of how the (hypothetical) service is used in routes.
       export default Ember.Route.extend({
        model(params) {
          return this.network.fetch(`/api/posts/${params.post_id}.json`);
        },
         afterModel(post) {
          if (post.isExternalContent) {
            return this.network.fetch(`/api/external/?url=${post.externalURL}`);
          } else {
            return post;
          }
        }
      });
      ```
       ```javascript
      // Finally, put all the pieces together
       function discoverResourcesFor(url) {
        return MyApp.visit(url, { isBrowser: false, shouldRender: false }).then(instance => {
          let networkService = instance.lookup('service:network');
          return networkService.requests; // => { "/api/posts/123.json": "..." }
        });
      }
      ```
       @method visit
      @param url {String} The initial URL to navigate to
      @param options {Ember.ApplicationInstance.BootOptions}
      @return {Promise<Ember.ApplicationInstance, Error>}
      @private
    */
    visit: function (url, options) {
      var _this = this;

      return this.boot().then(function () {
        return _this.buildInstance().boot(options).then(function (instance) {
          return instance.visit(url);
        });
      });
    }
  });

  Application.reopenClass({
    initializers: new _emberMetalEmpty_object.default(),
    instanceInitializers: new _emberMetalEmpty_object.default(),

    /**
      The goal of initializers should be to register dependencies and injections.
      This phase runs once. Because these initializers may load code, they are
      allowed to defer application readiness and advance it. If you need to access
      the container or store you should use an InstanceInitializer that will be run
      after all initializers and therefore after all code is loaded and the app is
      ready.
       Initializer receives an object which has the following attributes:
      `name`, `before`, `after`, `initialize`. The only required attribute is
      `initialize`, all others are optional.
       * `name` allows you to specify under which name the initializer is registered.
      This must be a unique name, as trying to register two initializers with the
      same name will result in an error.
       ```javascript
      Ember.Application.initializer({
        name: 'namedInitializer',
         initialize: function(application) {
          Ember.debug('Running namedInitializer!');
        }
      });
      ```
       * `before` and `after` are used to ensure that this initializer is ran prior
      or after the one identified by the value. This value can be a single string
      or an array of strings, referencing the `name` of other initializers.
       An example of ordering initializers, we create an initializer named `first`:
       ```javascript
      Ember.Application.initializer({
        name: 'first',
         initialize: function(application) {
          Ember.debug('First initializer!');
        }
      });
       // DEBUG: First initializer!
      ```
       We add another initializer named `second`, specifying that it should run
      after the initializer named `first`:
       ```javascript
      Ember.Application.initializer({
        name: 'second',
        after: 'first',
         initialize: function(application) {
          Ember.debug('Second initializer!');
        }
      });
       // DEBUG: First initializer!
      // DEBUG: Second initializer!
      ```
       Afterwards we add a further initializer named `pre`, this time specifying
      that it should run before the initializer named `first`:
       ```javascript
      Ember.Application.initializer({
        name: 'pre',
        before: 'first',
         initialize: function(application) {
          Ember.debug('Pre initializer!');
        }
      });
       // DEBUG: Pre initializer!
      // DEBUG: First initializer!
      // DEBUG: Second initializer!
      ```
       Finally we add an initializer named `post`, specifying it should run after
      both the `first` and the `second` initializers:
       ```javascript
      Ember.Application.initializer({
        name: 'post',
        after: ['first', 'second'],
         initialize: function(application) {
          Ember.debug('Post initializer!');
        }
      });
       // DEBUG: Pre initializer!
      // DEBUG: First initializer!
      // DEBUG: Second initializer!
      // DEBUG: Post initializer!
      ```
       * `initialize` is a callback function that receives one argument,
        `application`, on which you can operate.
       Example of using `application` to register an adapter:
       ```javascript
      Ember.Application.initializer({
        name: 'api-adapter',
         initialize: function(application) {
          application.register('api-adapter:main', ApiAdapter);
        }
      });
      ```
       @method initializer
      @param initializer {Object}
      @public
    */

    initializer: buildInitializerMethod('initializers', 'initializer'),

    /**
      This creates a registry with the default Ember naming conventions.
       It also configures the registry:
       * registered views are created every time they are looked up (they are
        not singletons)
      * registered templates are not factories; the registered value is
        returned directly.
      * the router receives the application as its `namespace` property
      * all controllers receive the router as their `target` and `controllers`
        properties
      * all controllers receive the application as their `namespace` property
      * the application view receives the application controller as its
        `controller` property
      * the application view receives the application template as its
        `defaultTemplate` property
       @private
      @method buildRegistry
      @static
      @param {Ember.Application} namespace the application for which to
        build the registry
      @return {Ember.Registry} the built registry
      @public
    */
    buildRegistry: function (namespace) {
      var registry = new _containerRegistry.default({
        resolver: resolverFor(namespace)
      });

      registry.set = _emberMetalProperty_set.set;

      registry.optionsForType('component', { singleton: false });
      registry.optionsForType('view', { singleton: false });
      registry.optionsForType('template', { instantiate: false });

      registry.register('application:main', namespace, { instantiate: false });

      registry.register('controller:basic', _emberRuntimeControllersController.default, { instantiate: false });

      registry.register('renderer:-dom', { create: function () {
          return new _emberMetalViewsRenderer.default(new _emberHtmlbarsSystemDomHelper.default());
        } });

      registry.injection('view', 'renderer', 'renderer:-dom');
      if (_emberMetal.default.ENV._ENABLE_LEGACY_VIEW_SUPPORT) {
        registry.register('view:select', _emberViewsViewsSelect.default);
      }
      registry.register('view:-outlet', _emberRoutingViewsViewsOutlet.OutletView);

      registry.register('-view-registry:main', { create: function () {
          return {};
        } });

      registry.injection('view', '_viewRegistry', '-view-registry:main');

      registry.register('view:toplevel', _emberViewsViewsView.default.extend());

      registry.register('route:basic', _emberRoutingSystemRoute.default, { instantiate: false });
      registry.register('event_dispatcher:main', _emberViewsSystemEvent_dispatcher.default);

      registry.injection('router:main', 'namespace', 'application:main');
      registry.injection('view:-outlet', 'namespace', 'application:main');

      registry.register('location:auto', _emberRoutingLocationAuto_location.default);
      registry.register('location:hash', _emberRoutingLocationHash_location.default);
      registry.register('location:history', _emberRoutingLocationHistory_location.default);
      registry.register('location:none', _emberRoutingLocationNone_location.default);

      registry.injection('controller', 'target', 'router:main');
      registry.injection('controller', 'namespace', 'application:main');

      registry.register('-bucket-cache:main', _emberRoutingSystemCache.default);
      registry.injection('router', '_bucketCache', '-bucket-cache:main');
      registry.injection('route', '_bucketCache', '-bucket-cache:main');
      registry.injection('controller', '_bucketCache', '-bucket-cache:main');

      registry.injection('route', 'router', 'router:main');

      registry.register('component:-text-field', _emberViewsViewsText_field.default);
      registry.register('component:-text-area', _emberViewsViewsText_area.default);
      registry.register('component:-checkbox', _emberViewsViewsCheckbox.default);
      registry.register('view:-legacy-each', _emberViewsViewsLegacy_each_view.default);
      registry.register('component:link-to', _emberRoutingViewsComponentsLinkTo.default);

      // Register the routing service...
      registry.register('service:-routing', _emberRoutingServicesRouting.default);
      // Then inject the app router into it
      registry.injection('service:-routing', 'router', 'router:main');

      // DEBUGGING
      registry.register('resolver-for-debugging:main', registry.resolver, { instantiate: false });
      registry.injection('container-debug-adapter:main', 'resolver', 'resolver-for-debugging:main');
      registry.injection('data-adapter:main', 'containerDebugAdapter', 'container-debug-adapter:main');
      // Custom resolver authors may want to register their own ContainerDebugAdapter with this key

      registry.register('container-debug-adapter:main', _emberExtensionSupportContainer_debug_adapter.default);

      return registry;
    }
  });

  /**
    This function defines the default lookup rules for container lookups:
  
    * templates are looked up on `Ember.TEMPLATES`
    * other names are looked up on the application after classifying the name.
      For example, `controller:post` looks up `App.PostController` by default.
    * if the default lookup fails, look for registered classes on the container
  
    This allows the application to register default injections in the container
    that could be overridden by the normal naming convention.
  
    @private
    @method resolverFor
    @param {Ember.Namespace} namespace the namespace to look for classes
    @return {*} the resolved value for a given lookup
  */
  function resolverFor(namespace) {
    var ResolverClass = namespace.get('Resolver') || _emberApplicationSystemResolver.default;

    return ResolverClass.create({
      namespace: namespace
    });
  }

  function registerLibraries() {
    if (!librariesRegistered) {
      librariesRegistered = true;

      if (_emberMetalEnvironment.default.hasDOM) {
        _emberMetal.default.libraries.registerCoreLibrary('jQuery', _emberViewsSystemJquery.default().jquery);
      }
    }
  }

  function logLibraryVersions() {
    if (_emberMetal.default.LOG_VERSION) {
      // we only need to see this once per Application#init
      _emberMetal.default.LOG_VERSION = false;
      var libs = _emberMetal.default.libraries._registry;

      var nameLengths = libs.map(function (item) {
        return _emberMetalProperty_get.get(item, 'name.length');
      });

      var maxNameLength = Math.max.apply(this, nameLengths);

      _emberMetalDebug.debug('-------------------------------');
      for (var i = 0, l = libs.length; i < l; i++) {
        var lib = libs[i];
        var spaces = new Array(maxNameLength - lib.name.length + 1).join(' ');
        _emberMetalDebug.debug([lib.name, spaces, ' : ', lib.version].join(''));
      }
      _emberMetalDebug.debug('-------------------------------');
    }
  }

  function buildInitializerMethod(bucketName, humanName) {
    return function (initializer) {
      // If this is the first initializer being added to a subclass, we are going to reopen the class
      // to make sure we have a new `initializers` object, which extends from the parent class' using
      // prototypal inheritance. Without this, attempting to add initializers to the subclass would
      // pollute the parent class as well as other subclasses.
      if (this.superclass[bucketName] !== undefined && this.superclass[bucketName] === this[bucketName]) {
        var attrs = {};
        attrs[bucketName] = Object.create(this[bucketName]);
        this.reopenClass(attrs);
      }

      _emberMetalDebug.assert('The ' + humanName + ' \'' + initializer.name + '\' has already been registered', !this[bucketName][initializer.name]);
      _emberMetalDebug.assert('An ' + humanName + ' cannot be registered without an initialize function', _emberMetalUtils.canInvoke(initializer, 'initialize'));
      _emberMetalDebug.assert('An ' + humanName + ' cannot be registered without a name property', initializer.name !== undefined);

      this[bucketName][initializer.name] = initializer;
    };
  }

  exports.default = Application;
});
// Ember.libraries, LOG_VERSION, Namespace, BOOTED

// Force-assign these flags to their default values when the feature is
// disabled, this ensures we can rely on their values in other paths.
enifed('ember-application/system/resolver', ['exports', 'ember-metal/debug', 'ember-metal/property_get', 'ember-runtime/system/string', 'ember-runtime/system/object', 'ember-runtime/system/namespace', 'ember-htmlbars/helpers', 'ember-application/utils/validate-type', 'ember-metal/dictionary', 'ember-htmlbars/template_registry'], function (exports, _emberMetalDebug, _emberMetalProperty_get, _emberRuntimeSystemString, _emberRuntimeSystemObject, _emberRuntimeSystemNamespace, _emberHtmlbarsHelpers, _emberApplicationUtilsValidateType, _emberMetalDictionary, _emberHtmlbarsTemplate_registry) {
  /**
  @module ember
  @submodule ember-application
  */

  'use strict';

  var Resolver = _emberRuntimeSystemObject.default.extend({
    /*
      This will be set to the Application instance when it is
      created.
       @property namespace
    */
    namespace: null,
    normalize: null, // required
    resolve: null, // required
    parseName: null, // required
    lookupDescription: null, // required
    makeToString: null, // required
    resolveOther: null, // required
    _logLookup: null // required
  });

  exports.Resolver = Resolver;
  /**
    The DefaultResolver defines the default lookup rules to resolve
    container lookups before consulting the container for registered
    items:
  
    * templates are looked up on `Ember.TEMPLATES`
    * other names are looked up on the application after converting
      the name. For example, `controller:post` looks up
      `App.PostController` by default.
    * there are some nuances (see examples below)
  
    ### How Resolving Works
  
    The container calls this object's `resolve` method with the
    `fullName` argument.
  
    It first parses the fullName into an object using `parseName`.
  
    Then it checks for the presence of a type-specific instance
    method of the form `resolve[Type]` and calls it if it exists.
    For example if it was resolving 'template:post', it would call
    the `resolveTemplate` method.
  
    Its last resort is to call the `resolveOther` method.
  
    The methods of this object are designed to be easy to override
    in a subclass. For example, you could enhance how a template
    is resolved like so:
  
    ```javascript
    App = Ember.Application.create({
      Resolver: Ember.DefaultResolver.extend({
        resolveTemplate: function(parsedName) {
          var resolvedTemplate = this._super(parsedName);
          if (resolvedTemplate) { return resolvedTemplate; }
          return Ember.TEMPLATES['not_found'];
        }
      })
    });
    ```
  
    Some examples of how names are resolved:
  
    ```
    'template:post'           //=> Ember.TEMPLATES['post']
    'template:posts/byline'   //=> Ember.TEMPLATES['posts/byline']
    'template:posts.byline'   //=> Ember.TEMPLATES['posts/byline']
    'template:blogPost'       //=> Ember.TEMPLATES['blogPost']
                              //   OR
                              //   Ember.TEMPLATES['blog_post']
    'controller:post'         //=> App.PostController
    'controller:posts.index'  //=> App.PostsIndexController
    'controller:blog/post'    //=> Blog.PostController
    'controller:basic'        //=> Ember.Controller
    'route:post'              //=> App.PostRoute
    'route:posts.index'       //=> App.PostsIndexRoute
    'route:blog/post'         //=> Blog.PostRoute
    'route:basic'             //=> Ember.Route
    'view:post'               //=> App.PostView
    'view:posts.index'        //=> App.PostsIndexView
    'view:blog/post'          //=> Blog.PostView
    'view:basic'              //=> Ember.View
    'foo:post'                //=> App.PostFoo
    'model:post'              //=> App.Post
    ```
  
    @class DefaultResolver
    @namespace Ember
    @extends Ember.Object
    @public
  */

  exports.default = _emberRuntimeSystemObject.default.extend({
    /**
      This will be set to the Application instance when it is
      created.
       @property namespace
      @public
    */
    namespace: null,

    init: function () {
      this._parseNameCache = _emberMetalDictionary.default(null);
    },
    normalize: function (fullName) {
      var _fullName$split = fullName.split(':', 2);

      var type = _fullName$split[0];
      var name = _fullName$split[1];

      _emberMetalDebug.assert('Tried to normalize a container name without a colon (:) in it. ' + 'You probably tried to lookup a name that did not contain a type, ' + 'a colon, and a name. A proper lookup name would be `view:post`.', fullName.split(':').length === 2);

      if (type !== 'template') {
        var result = name;

        if (result.indexOf('.') > -1) {
          result = result.replace(/\.(.)/g, function (m) {
            return m.charAt(1).toUpperCase();
          });
        }

        if (name.indexOf('_') > -1) {
          result = result.replace(/_(.)/g, function (m) {
            return m.charAt(1).toUpperCase();
          });
        }

        if (name.indexOf('-') > -1) {
          result = result.replace(/-(.)/g, function (m) {
            return m.charAt(1).toUpperCase();
          });
        }

        return type + ':' + result;
      } else {
        return fullName;
      }
    },

    /**
      This method is called via the container's resolver method.
      It parses the provided `fullName` and then looks up and
      returns the appropriate template or class.
       @method resolve
      @param {String} fullName the lookup string
      @return {Object} the resolved factory
      @public
    */
    resolve: function (fullName) {
      var parsedName = this.parseName(fullName);
      var resolveMethodName = parsedName.resolveMethodName;
      var resolved;

      if (this[resolveMethodName]) {
        resolved = this[resolveMethodName](parsedName);
      }

      resolved = resolved || this.resolveOther(parsedName);

      if (parsedName.root && parsedName.root.LOG_RESOLVER) {
        this._logLookup(resolved, parsedName);
      }

      if (resolved) {
        _emberApplicationUtilsValidateType.default(resolved, parsedName);
      }

      return resolved;
    },

    /**
      Convert the string name of the form 'type:name' to
      a Javascript object with the parsed aspects of the name
      broken out.
       @protected
      @param {String} fullName the lookup string
      @method parseName
      @public
    */

    parseName: function (fullName) {
      return this._parseNameCache[fullName] || (this._parseNameCache[fullName] = this._parseName(fullName));
    },

    _parseName: function (fullName) {
      var _fullName$split2 = fullName.split(':');

      var type = _fullName$split2[0];
      var fullNameWithoutType = _fullName$split2[1];

      var name = fullNameWithoutType;
      var namespace = _emberMetalProperty_get.get(this, 'namespace');
      var root = namespace;

      if (type !== 'template' && name.indexOf('/') !== -1) {
        var parts = name.split('/');
        name = parts[parts.length - 1];
        var namespaceName = _emberRuntimeSystemString.capitalize(parts.slice(0, -1).join('.'));
        root = _emberRuntimeSystemNamespace.default.byName(namespaceName);

        _emberMetalDebug.assert('You are looking for a ' + name + ' ' + type + ' in the ' + namespaceName + ' namespace, but the namespace could not be found', root);
      }

      var resolveMethodName = fullNameWithoutType === 'main' ? 'Main' : _emberRuntimeSystemString.classify(type);

      if (!(name && type)) {
        throw new TypeError('Invalid fullName: `' + fullName + '`, must be of the form `type:name` ');
      }

      return {
        fullName: fullName,
        type: type,
        fullNameWithoutType: fullNameWithoutType,
        name: name,
        root: root,
        resolveMethodName: 'resolve' + resolveMethodName
      };
    },

    /**
      Returns a human-readable description for a fullName. Used by the
      Application namespace in assertions to describe the
      precise name of the class that Ember is looking for, rather than
      container keys.
       @protected
      @param {String} fullName the lookup string
      @method lookupDescription
      @public
    */
    lookupDescription: function (fullName) {
      var parsedName = this.parseName(fullName);
      var description;

      if (parsedName.type === 'template') {
        return 'template at ' + parsedName.fullNameWithoutType.replace(/\./g, '/');
      }

      description = parsedName.root + '.' + _emberRuntimeSystemString.classify(parsedName.name).replace(/\./g, '');

      if (parsedName.type !== 'model') {
        description += _emberRuntimeSystemString.classify(parsedName.type);
      }

      return description;
    },

    makeToString: function (factory, fullName) {
      return factory.toString();
    },

    /**
      Given a parseName object (output from `parseName`), apply
      the conventions expected by `Ember.Router`
       @protected
      @param {Object} parsedName a parseName object with the parsed
        fullName lookup string
      @method useRouterNaming
      @public
    */
    useRouterNaming: function (parsedName) {
      parsedName.name = parsedName.name.replace(/\./g, '_');
      if (parsedName.name === 'basic') {
        parsedName.name = '';
      }
    },
    /**
      Look up the template in Ember.TEMPLATES
       @protected
      @param {Object} parsedName a parseName object with the parsed
        fullName lookup string
      @method resolveTemplate
      @public
    */
    resolveTemplate: function (parsedName) {
      var templateName = parsedName.fullNameWithoutType.replace(/\./g, '/');

      return _emberHtmlbarsTemplate_registry.get(templateName) || _emberHtmlbarsTemplate_registry.get(_emberRuntimeSystemString.decamelize(templateName));
    },

    /**
      Lookup the view using `resolveOther`
       @protected
      @param {Object} parsedName a parseName object with the parsed
        fullName lookup string
      @method resolveView
      @public
    */
    resolveView: function (parsedName) {
      this.useRouterNaming(parsedName);
      return this.resolveOther(parsedName);
    },

    /**
      Lookup the controller using `resolveOther`
       @protected
      @param {Object} parsedName a parseName object with the parsed
        fullName lookup string
      @method resolveController
      @public
    */
    resolveController: function (parsedName) {
      this.useRouterNaming(parsedName);
      return this.resolveOther(parsedName);
    },
    /**
      Lookup the route using `resolveOther`
       @protected
      @param {Object} parsedName a parseName object with the parsed
        fullName lookup string
      @method resolveRoute
      @public
    */
    resolveRoute: function (parsedName) {
      this.useRouterNaming(parsedName);
      return this.resolveOther(parsedName);
    },

    /**
      Lookup the model on the Application namespace
       @protected
      @param {Object} parsedName a parseName object with the parsed
        fullName lookup string
      @method resolveModel
      @public
    */
    resolveModel: function (parsedName) {
      var className = _emberRuntimeSystemString.classify(parsedName.name);
      var factory = _emberMetalProperty_get.get(parsedName.root, className);

      if (factory) {
        return factory;
      }
    },
    /**
      Look up the specified object (from parsedName) on the appropriate
      namespace (usually on the Application)
       @protected
      @param {Object} parsedName a parseName object with the parsed
        fullName lookup string
      @method resolveHelper
      @public
    */
    resolveHelper: function (parsedName) {
      return this.resolveOther(parsedName) || _emberHtmlbarsHelpers.default[parsedName.fullNameWithoutType];
    },
    /**
      Look up the specified object (from parsedName) on the appropriate
      namespace (usually on the Application)
       @protected
      @param {Object} parsedName a parseName object with the parsed
        fullName lookup string
      @method resolveOther
      @public
    */
    resolveOther: function (parsedName) {
      var className = _emberRuntimeSystemString.classify(parsedName.name) + _emberRuntimeSystemString.classify(parsedName.type);
      var factory = _emberMetalProperty_get.get(parsedName.root, className);
      if (factory) {
        return factory;
      }
    },

    resolveMain: function (parsedName) {
      var className = _emberRuntimeSystemString.classify(parsedName.type);
      return _emberMetalProperty_get.get(parsedName.root, className);
    },

    /**
     @method _logLookup
     @param {Boolean} found
     @param {Object} parsedName
     @private
    */
    _logLookup: function (found, parsedName) {
      var symbol, padding;

      if (found) {
        symbol = '[âœ“]';
      } else {
        symbol = '[ ]';
      }

      if (parsedName.fullName.length > 60) {
        padding = '.';
      } else {
        padding = new Array(60 - parsedName.fullName.length).join('.');
      }

      _emberMetalDebug.info(symbol, parsedName.fullName, padding, this.lookupDescription(parsedName.fullName));
    },

    /**
     Used to iterate all items of a given type.
      @method knownForType
     @param {String} type the type to search for
     @private
     */
    knownForType: function (type) {
      var namespace = _emberMetalProperty_get.get(this, 'namespace');
      var suffix = _emberRuntimeSystemString.classify(type);
      var typeRegexp = new RegExp(suffix + '$');

      var known = _emberMetalDictionary.default(null);
      var knownKeys = Object.keys(namespace);
      for (var index = 0, _length = knownKeys.length; index < _length; index++) {
        var _name = knownKeys[index];

        if (typeRegexp.test(_name)) {
          var containerName = this.translateToContainerFullname(type, _name);

          known[containerName] = true;
        }
      }

      return known;
    },

    /**
     Converts provided name from the backing namespace into a container lookup name.
      Examples:
      App.FooBarHelper -> helper:foo-bar
     App.THelper -> helper:t
      @method translateToContainerFullname
     @param {String} type
     @param {String} name
     @private
     */

    translateToContainerFullname: function (type, name) {
      var suffix = _emberRuntimeSystemString.classify(type);
      var namePrefix = name.slice(0, suffix.length * -1);
      var dasherizedName = _emberRuntimeSystemString.dasherize(namePrefix);

      return type + ':' + dasherizedName;
    }
  });
});
enifed('ember-application/utils/validate-type', ['exports', 'ember-metal/debug'], function (exports, _emberMetalDebug) {
  /**
  @module ember
  @submodule ember-application
  */

  'use strict';

  exports.default = validateType;

  var VALIDATED_TYPES = {
    route: ['assert', 'isRouteFactory', 'Ember.Route'],
    component: ['deprecate', 'isComponentFactory', 'Ember.Component'],
    view: ['deprecate', 'isViewFactory', 'Ember.View'],
    service: ['deprecate', 'isServiceFactory', 'Ember.Service']
  };

  function validateType(resolvedType, parsedName) {
    var validationAttributes = VALIDATED_TYPES[parsedName.type];

    if (!validationAttributes) {
      return;
    }

    var action = validationAttributes[0];
    var factoryFlag = validationAttributes[1];
    var expectedType = validationAttributes[2];

    if (action === 'deprecate') {
      _emberMetalDebug.deprecate('In Ember 2.0 ' + parsedName.type + ' factories must have an `' + factoryFlag + '` ' + ('property set to true. You registered ' + resolvedType + ' as a ' + parsedName.type + ' ') + ('factory. Either add the `' + factoryFlag + '` property to this factory or ') + ('extend from ' + expectedType + '.'), !!resolvedType[factoryFlag], { id: 'ember-application.validate-type', until: '3.0.0' });
    } else {
      _emberMetalDebug.assert('Expected ' + parsedName.fullName + ' to resolve to an ' + expectedType + ' but ' + ('instead it was ' + resolvedType + '.'), !!resolvedType[factoryFlag]);
    }
  }
});
enifed('ember-application', ['exports', 'ember-metal/core', 'ember-runtime/system/lazy_load', 'ember-application/system/resolver', 'ember-application/system/application'], function (exports, _emberMetalCore, _emberRuntimeSystemLazy_load, _emberApplicationSystemResolver, _emberApplicationSystemApplication) {
  'use strict';

  _emberMetalCore.default.Application = _emberApplicationSystemApplication.default;
  _emberMetalCore.default.Resolver = _emberApplicationSystemResolver.Resolver;
  _emberMetalCore.default.DefaultResolver = _emberApplicationSystemResolver.default;

  _emberRuntimeSystemLazy_load.runLoadHooks('Ember.Application', _emberApplicationSystemApplication.default);
});

/**
@module ember
@submodule ember-application
*/
enifed('ember-debug/deprecate', ['exports', 'ember-metal/core', 'ember-metal/error', 'ember-metal/logger', 'ember-debug/handlers'], function (exports, _emberMetalCore, _emberMetalError, _emberMetalLogger, _emberDebugHandlers) {
  /*global __fail__*/

  'use strict';

  var _slice = Array.prototype.slice;
  exports.registerHandler = registerHandler;
  exports.default = deprecate;

  function registerHandler(handler) {
    _emberDebugHandlers.registerHandler('deprecate', handler);
  }

  function formatMessage(_message, options) {
    var message = _message;

    if (options && options.id) {
      message = message + (' [deprecation id: ' + options.id + ']');
    }

    if (options && options.url) {
      message += ' See ' + options.url + ' for more details.';
    }

    return message;
  }

  registerHandler(function logDeprecationToConsole(message, options) {
    var updatedMessage = formatMessage(message, options);

    _emberMetalLogger.default.warn('DEPRECATION: ' + updatedMessage);
  });

  registerHandler(function logDeprecationStackTrace(message, options, next) {
    if (_emberMetalCore.default.LOG_STACKTRACE_ON_DEPRECATION) {
      var stackStr = '';
      var error = undefined,
          stack = undefined;

      // When using new Error, we can't do the arguments check for Chrome. Alternatives are welcome
      try {
        __fail__.fail();
      } catch (e) {
        error = e;
      }

      if (error.stack) {
        if (error['arguments']) {
          // Chrome
          stack = error.stack.replace(/^\s+at\s+/gm, '').replace(/^([^\(]+?)([\n$])/gm, '{anonymous}($1)$2').replace(/^Object.<anonymous>\s*\(([^\)]+)\)/gm, '{anonymous}($1)').split('\n');
          stack.shift();
        } else {
          // Firefox
          stack = error.stack.replace(/(?:\n@:0)?\s+$/m, '').replace(/^\(/gm, '{anonymous}(').split('\n');
        }

        stackStr = '\n    ' + stack.slice(2).join('\n    ');
      }

      var updatedMessage = formatMessage(message, options);

      _emberMetalLogger.default.warn('DEPRECATION: ' + updatedMessage + stackStr);
    } else {
      next.apply(undefined, arguments);
    }
  });

  registerHandler(function raiseOnDeprecation(message, options, next) {
    if (_emberMetalCore.default.ENV.RAISE_ON_DEPRECATION) {
      var updatedMessage = formatMessage(message);

      throw new _emberMetalError.default(updatedMessage);
    } else {
      next.apply(undefined, arguments);
    }
  });

  var missingOptionsDeprecation = 'When calling `Ember.deprecate` you ' + 'must provide an `options` hash as the third parameter.  ' + '`options` should include `id` and `until` properties.';
  exports.missingOptionsDeprecation = missingOptionsDeprecation;
  var missingOptionsIdDeprecation = 'When calling `Ember.deprecate` you must provide `id` in options.';
  exports.missingOptionsIdDeprecation = missingOptionsIdDeprecation;
  var missingOptionsUntilDeprecation = 'When calling `Ember.deprecate` you must provide `until` in options.';

  exports.missingOptionsUntilDeprecation = missingOptionsUntilDeprecation;
  /**
  @module ember
  @submodule ember-debug
  */

  /**
    Display a deprecation warning with the provided message and a stack trace
    (Chrome and Firefox only). Ember build tools will remove any calls to
    `Ember.deprecate()` when doing a production build.
  
    @method deprecate
    @param {String} message A description of the deprecation.
    @param {Boolean} test A boolean. If falsy, the deprecation
      will be displayed.
    @param {Object} options An object that can be used to pass
      in a `url` to the transition guide on the emberjs.com website, and a unique
      `id` for this deprecation. The `id` can be used by Ember debugging tools
      to change the behavior (raise, log or silence) for that specific deprecation.
      The `id` should be namespaced by dots, e.g. "view.helper.select".
    @for Ember
    @public
  */

  function deprecate(message, test, options) {
    if (!options || !options.id && !options.until) {
      deprecate(missingOptionsDeprecation, false, {
        id: 'ember-debug.deprecate-options-missing',
        until: '3.0.0',
        url: 'http://emberjs.com/deprecations/v2.x/#toc_ember-debug-function-options'
      });
    }

    if (options && !options.id) {
      deprecate(missingOptionsIdDeprecation, false, {
        id: 'ember-debug.deprecate-id-missing',
        until: '3.0.0',
        url: 'http://emberjs.com/deprecations/v2.x/#toc_ember-debug-function-options'
      });
    }

    if (options && !options.until) {
      deprecate(missingOptionsUntilDeprecation, options && options.until, {
        id: 'ember-debug.deprecate-until-missing',
        until: '3.0.0',
        url: 'http://emberjs.com/deprecations/v2.x/#toc_ember-debug-function-options'
      });
    }

    _emberDebugHandlers.invoke.apply(undefined, ['deprecate'].concat(_slice.call(arguments)));
  }
});
enifed('ember-debug/handlers', ['exports', 'ember-debug/is-plain-function', 'ember-debug/deprecate'], function (exports, _emberDebugIsPlainFunction, _emberDebugDeprecate) {
  'use strict';

  exports.generateTestAsFunctionDeprecation = generateTestAsFunctionDeprecation;
  exports.registerHandler = registerHandler;
  exports.invoke = invoke;
  var HANDLERS = {};

  exports.HANDLERS = HANDLERS;

  function generateTestAsFunctionDeprecation(source) {
    return 'Calling `' + source + '` with a function argument is deprecated. Please ' + 'use `!!Constructor` for constructors, or an `IIFE` to compute the test for deprecation. ' + 'In a future version functions will be treated as truthy values instead of being executed.';
  }

  function normalizeTest(test, source) {
    if (_emberDebugIsPlainFunction.default(test)) {
      _emberDebugDeprecate.default(generateTestAsFunctionDeprecation(source), false, { id: 'ember-debug.deprecate-test-as-function', until: '2.5.0' });

      return test();
    }

    return test;
  }

  function registerHandler(type, callback) {
    var nextHandler = HANDLERS[type] || function () {};

    HANDLERS[type] = function (message, options) {
      callback(message, options, nextHandler);
    };
  }

  function invoke(type, message, test, options) {
    if (normalizeTest(test, 'Ember.' + type)) {
      return;
    }

    var handlerForType = HANDLERS[type];

    if (!handlerForType) {
      return;
    }

    if (handlerForType) {
      handlerForType(message, options);
    }
  }
});
enifed('ember-debug/is-plain-function', ['exports'], function (exports) {
  'use strict';

  exports.default = isPlainFunction;

  function isPlainFunction(test) {
    return typeof test === 'function' && test.PrototypeMixin === undefined;
  }
});
enifed('ember-debug/warn', ['exports', 'ember-metal/logger', 'ember-metal/debug', 'ember-debug/handlers'], function (exports, _emberMetalLogger, _emberMetalDebug, _emberDebugHandlers) {
  'use strict';

  var _slice = Array.prototype.slice;
  exports.registerHandler = registerHandler;
  exports.default = warn;

  function registerHandler(handler) {
    _emberDebugHandlers.registerHandler('warn', handler);
  }

  registerHandler(function logWarning(message, options) {
    _emberMetalLogger.default.warn('WARNING: ' + message);
    if ('trace' in _emberMetalLogger.default) {
      _emberMetalLogger.default.trace();
    }
  });

  var missingOptionsDeprecation = 'When calling `Ember.warn` you ' + 'must provide an `options` hash as the third parameter.  ' + '`options` should include an `id` property.';
  exports.missingOptionsDeprecation = missingOptionsDeprecation;
  var missingOptionsIdDeprecation = 'When calling `Ember.warn` you must provide `id` in options.';

  exports.missingOptionsIdDeprecation = missingOptionsIdDeprecation;
  /**
  @module ember
  @submodule ember-debug
  */

  /**
    Display a warning with the provided message. Ember build tools will
    remove any calls to `Ember.warn()` when doing a production build.
  
    @method warn
    @param {String} message A warning to display.
    @param {Boolean} test An optional boolean. If falsy, the warning
      will be displayed.
    @param {Object} options An ojbect that can be used to pass a unique
      `id` for this warning.  The `id` can be used by Ember debugging tools
      to change the behavior (raise, log, or silence) for that specific warning.
      The `id` should be namespaced by dots, e.g. "ember-debug.feature-flag-with-features-stripped"
    @for Ember
    @public
  */

  function warn(message, test, options) {
    if (!options) {
      _emberMetalDebug.deprecate(missingOptionsDeprecation, false, {
        id: 'ember-debug.warn-options-missing',
        until: '3.0.0',
        url: 'http://emberjs.com/deprecations/v2.x/#toc_ember-debug-function-options'
      });
    }

    if (options && !options.id) {
      _emberMetalDebug.deprecate(missingOptionsIdDeprecation, false, {
        id: 'ember-debug.warn-id-missing',
        until: '3.0.0',
        url: 'http://emberjs.com/deprecations/v2.x/#toc_ember-debug-function-options'
      });
    }

    _emberDebugHandlers.invoke.apply(undefined, ['warn'].concat(_slice.call(arguments)));
  }
});
enifed('ember-debug', ['exports', 'ember-metal/core', 'ember-metal/debug', 'ember-metal/features', 'ember-metal/error', 'ember-metal/logger', 'ember-metal/environment', 'ember-debug/deprecate', 'ember-debug/warn', 'ember-debug/is-plain-function', 'ember-debug/handlers'], function (exports, _emberMetalCore, _emberMetalDebug, _emberMetalFeatures, _emberMetalError, _emberMetalLogger, _emberMetalEnvironment, _emberDebugDeprecate, _emberDebugWarn, _emberDebugIsPlainFunction, _emberDebugHandlers) {
  'use strict';

  exports._warnIfUsingStrippedFeatureFlags = _warnIfUsingStrippedFeatureFlags;

  /**
  @module ember
  @submodule ember-debug
  */

  /**
  @class Ember
  @public
  */

  /**
    Define an assertion that will throw an exception if the condition is not
    met. Ember build tools will remove any calls to `Ember.assert()` when
    doing a production build. Example:
  
    ```javascript
    // Test for truthiness
    Ember.assert('Must pass a valid object', obj);
  
    // Fail unconditionally
    Ember.assert('This code path should never be run');
    ```
  
    @method assert
    @param {String} desc A description of the assertion. This will become
      the text of the Error thrown if the assertion fails.
    @param {Boolean} test Must be truthy for the assertion to pass. If
      falsy, an exception will be thrown.
    @public
  */
  _emberMetalDebug.setDebugFunction('assert', function assert(desc, test) {
    var throwAssertion = undefined;

    if (_emberDebugIsPlainFunction.default(test)) {
      _emberMetalDebug.deprecate(_emberDebugHandlers.generateTestAsFunctionDeprecation('Ember.assert'), false, { id: 'ember-debug.deprecate-test-as-function', until: '2.5.0' });

      throwAssertion = !test();
    } else {
      throwAssertion = !test;
    }

    if (throwAssertion) {
      throw new _emberMetalError.default('Assertion Failed: ' + desc);
    }
  });

  /**
    Display a debug notice. Ember build tools will remove any calls to
    `Ember.debug()` when doing a production build.
  
    ```javascript
    Ember.debug('I\'m a debug notice!');
    ```
  
    @method debug
    @param {String} message A debug message to display.
    @public
  */
  _emberMetalDebug.setDebugFunction('debug', function debug(message) {
    _emberMetalLogger.default.debug('DEBUG: ' + message);
  });

  /**
    Display an info notice.
  
    @method info
    @private
  */
  _emberMetalDebug.setDebugFunction('info', function info() {
    _emberMetalLogger.default.info.apply(undefined, arguments);
  });

  /**
    Alias an old, deprecated method with its new counterpart.
  
    Display a deprecation warning with the provided message and a stack trace
    (Chrome and Firefox only) when the assigned method is called.
  
    Ember build tools will not remove calls to `Ember.deprecateFunc()`, though
    no warnings will be shown in production.
  
    ```javascript
    Ember.oldMethod = Ember.deprecateFunc('Please use the new, updated method', Ember.newMethod);
    ```
  
    @method deprecateFunc
    @param {String} message A description of the deprecation.
    @param {Object} [options] The options object for Ember.deprecate.
    @param {Function} func The new function called to replace its deprecated counterpart.
    @return {Function} a new function that wrapped the original function with a deprecation warning
    @private
  */
  _emberMetalDebug.setDebugFunction('deprecateFunc', function deprecateFunc() {
    for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    if (args.length === 3) {
      var _ret = (function () {
        var message = args[0];
        var options = args[1];
        var func = args[2];

        return {
          v: function () {
            _emberMetalDebug.deprecate(message, false, options);
            return func.apply(this, arguments);
          }
        };
      })();

      if (typeof _ret === 'object') return _ret.v;
    } else {
      var _ret2 = (function () {
        var message = args[0];
        var func = args[1];

        return {
          v: function () {
            _emberMetalDebug.deprecate(message);
            return func.apply(this, arguments);
          }
        };
      })();

      if (typeof _ret2 === 'object') return _ret2.v;
    }
  });

  /**
    Run a function meant for debugging. Ember build tools will remove any calls to
    `Ember.runInDebug()` when doing a production build.
  
    ```javascript
    Ember.runInDebug(() => {
      Ember.Component.reopen({
        didInsertElement() {
          console.log("I'm happy");
        }
      });
    });
    ```
  
    @method runInDebug
    @param {Function} func The function to be executed.
    @since 1.5.0
    @public
  */
  _emberMetalDebug.setDebugFunction('runInDebug', function runInDebug(func) {
    func();
  });

  _emberMetalDebug.setDebugFunction('debugSeal', function debugSeal(obj) {
    Object.seal(obj);
  });

  _emberMetalDebug.setDebugFunction('deprecate', _emberDebugDeprecate.default);

  _emberMetalDebug.setDebugFunction('warn', _emberDebugWarn.default);

  /**
    Will call `Ember.warn()` if ENABLE_OPTIONAL_FEATURES or
    any specific FEATURES flag is truthy.
  
    This method is called automatically in debug canary builds.
  
    @private
    @method _warnIfUsingStrippedFeatureFlags
    @return {void}
  */

  function _warnIfUsingStrippedFeatureFlags(FEATURES, featuresWereStripped) {
    if (featuresWereStripped) {
      _emberMetalDebug.warn('Ember.ENV.ENABLE_OPTIONAL_FEATURES is only available in canary builds.', !_emberMetalCore.default.ENV.ENABLE_OPTIONAL_FEATURES, { id: 'ember-debug.feature-flag-with-features-stripped' });

      for (var key in FEATURES) {
        if (FEATURES.hasOwnProperty(key) && key !== 'isEnabled') {
          _emberMetalDebug.warn('FEATURE["' + key + '"] is set as enabled, but FEATURE flags are only available in canary builds.', !FEATURES[key], { id: 'ember-debug.feature-flag-with-features-stripped' });
        }
      }
    }
  }

  if (!_emberMetalCore.default.testing) {
    // Complain if they're using FEATURE flags in builds other than canary
    _emberMetalFeatures.FEATURES['features-stripped-test'] = true;
    var featuresWereStripped = true;

    delete _emberMetalFeatures.FEATURES['features-stripped-test'];
    _warnIfUsingStrippedFeatureFlags(_emberMetalCore.default.ENV.FEATURES, featuresWereStripped);

    // Inform the developer about the Ember Inspector if not installed.
    var isFirefox = _emberMetalEnvironment.default.isFirefox;
    var isChrome = _emberMetalEnvironment.default.isChrome;

    if (typeof window !== 'undefined' && (isFirefox || isChrome) && window.addEventListener) {
      window.addEventListener('load', function () {
        if (document.documentElement && document.documentElement.dataset && !document.documentElement.dataset.emberExtension) {
          var downloadURL;

          if (isChrome) {
            downloadURL = 'https://chrome.google.com/webstore/detail/ember-inspector/bmdblncegkenkacieihfhpjfppoconhi';
          } else if (isFirefox) {
            downloadURL = 'https://addons.mozilla.org/en-US/firefox/addon/ember-inspector/';
          }

          _emberMetalDebug.debug('For more advanced debugging, install the Ember Inspector from ' + downloadURL);
        }
      }, false);
    }
  }
  /**
    @public
    @class Ember.Debug
  */
  _emberMetalCore.default.Debug = {};

  /**
    Allows for runtime registration of handler functions that override the default deprecation behavior.
    Deprecations are invoked by calls to [Ember.deprecate](http://emberjs.com/api/classes/Ember.html#method_deprecate).
    The following example demonstrates its usage by registering a handler that throws an error if the
    message contains the word "should", otherwise defers to the default handler.
     ```javascript
    Ember.Debug.registerDeprecationHandler((message, options, next) => {
      if (message.indexOf('should') !== -1) {
        throw new Error(`Deprecation message with should: ${message}`);
      } else {
        // defer to whatever handler was registered before this one
        next(message, options);
      }
    }
    ```
     The handler function takes the following arguments:
     <ul>
      <li> <code>message</code> - The message received from the deprecation call. </li>
      <li> <code>options</code> - An object passed in with the deprecation call containing additional information including:</li>
        <ul>
          <li> <code>id</code> - an id of the deprecation in the form of <code>package-name.specific-deprecation</code>.</li>
          <li> <code>until</code> - is the version number Ember the feature and deprecation will be removed in.</li>
        </ul>
      <li> <code>next</code> - a function that calls into the previously registered handler.</li>
    </ul>
     @public
    @static
    @method registerDeprecationHandler
    @param handler {Function} a function to handle deprecation calls
    @since 2.1.0
  */
  _emberMetalCore.default.Debug.registerDeprecationHandler = _emberDebugDeprecate.registerHandler;
  /**
    Allows for runtime registration of handler functions that override the default warning behavior.
    Warnings are invoked by calls made to [Ember.warn](http://emberjs.com/api/classes/Ember.html#method_warn).
    The following example demonstrates its usage by registering a handler that does nothing overriding Ember's
    default warning behavior.
     ```javascript
    // next is not called, so no warnings get the default behavior
    Ember.Debug.registerWarnHandler(() => {});
    ```
     The handler function takes the following arguments:
     <ul>
      <li> <code>message</code> - The message received from the warn call. </li>
      <li> <code>options</code> - An object passed in with the warn call containing additional information including:</li>
        <ul>
          <li> <code>id</code> - an id of the warning in the form of <code>package-name.specific-warning</code>.</li>
        </ul>
      <li> <code>next</code> - a function that calls into the previously registered handler.</li>
    </ul>
     @public
    @static
    @method registerWarnHandler
    @param handler {Function} a function to handle warnings
    @since 2.1.0
  */
  _emberMetalCore.default.Debug.registerWarnHandler = _emberDebugWarn.registerHandler;

  /*
    We are transitioning away from `ember.js` to `ember.debug.js` to make
    it much clearer that it is only for local development purposes.
  
    This flag value is changed by the tooling (by a simple string replacement)
    so that if `ember.js` (which must be output for backwards compat reasons) is
    used a nice helpful warning message will be printed out.
  */
  var runningNonEmberDebugJS = true;
  exports.runningNonEmberDebugJS = runningNonEmberDebugJS;
  if (runningNonEmberDebugJS) {
    _emberMetalDebug.warn('Please use `ember.debug.js` instead of `ember.js` for development and debugging.');
  }
});
enifed('ember-extension-support/container_debug_adapter', ['exports', 'ember-metal/core', 'ember-runtime/system/native_array', 'ember-runtime/utils', 'ember-runtime/system/string', 'ember-runtime/system/namespace', 'ember-runtime/system/object'], function (exports, _emberMetalCore, _emberRuntimeSystemNative_array, _emberRuntimeUtils, _emberRuntimeSystemString, _emberRuntimeSystemNamespace, _emberRuntimeSystemObject) {
  'use strict';

  /**
  @module ember
  @submodule ember-extension-support
  */

  /**
    The `ContainerDebugAdapter` helps the container and resolver interface
    with tools that debug Ember such as the
    [Ember Extension](https://github.com/tildeio/ember-extension)
    for Chrome and Firefox.
  
    This class can be extended by a custom resolver implementer
    to override some of the methods with library-specific code.
  
    The methods likely to be overridden are:
  
    * `canCatalogEntriesByType`
    * `catalogEntriesByType`
  
    The adapter will need to be registered
    in the application's container as `container-debug-adapter:main`
  
    Example:
  
    ```javascript
    Application.initializer({
      name: "containerDebugAdapter",
  
      initialize: function(application) {
        application.register('container-debug-adapter:main', require('app/container-debug-adapter'));
      }
    });
    ```
  
    @class ContainerDebugAdapter
    @namespace Ember
    @extends Ember.Object
    @since 1.5.0
    @public
  */
  exports.default = _emberRuntimeSystemObject.default.extend({
    /**
      The resolver instance of the application
      being debugged. This property will be injected
      on creation.
       @property resolver
      @default null
      @public
    */
    resolver: null,

    /**
      Returns true if it is possible to catalog a list of available
      classes in the resolver for a given type.
       @method canCatalogEntriesByType
      @param {String} type The type. e.g. "model", "controller", "route"
      @return {boolean} whether a list is available for this type.
      @public
    */
    canCatalogEntriesByType: function (type) {
      if (type === 'model' || type === 'template') {
        return false;
      }

      return true;
    },

    /**
      Returns the available classes a given type.
       @method catalogEntriesByType
      @param {String} type The type. e.g. "model", "controller", "route"
      @return {Array} An array of strings.
      @public
    */
    catalogEntriesByType: function (type) {
      var namespaces = _emberRuntimeSystemNative_array.A(_emberRuntimeSystemNamespace.default.NAMESPACES);
      var types = _emberRuntimeSystemNative_array.A();
      var typeSuffixRegex = new RegExp(_emberRuntimeSystemString.classify(type) + '$');

      namespaces.forEach(function (namespace) {
        if (namespace !== _emberMetalCore.default) {
          for (var key in namespace) {
            if (!namespace.hasOwnProperty(key)) {
              continue;
            }
            if (typeSuffixRegex.test(key)) {
              var klass = namespace[key];
              if (_emberRuntimeUtils.typeOf(klass) === 'class') {
                types.push(_emberRuntimeSystemString.dasherize(key.replace(typeSuffixRegex, '')));
              }
            }
          }
        }
      });
      return types;
    }
  });
});
enifed('ember-extension-support/data_adapter', ['exports', 'ember-metal/property_get', 'ember-metal/run_loop', 'ember-runtime/system/string', 'ember-runtime/system/namespace', 'ember-runtime/system/object', 'ember-runtime/system/native_array', 'ember-application/system/application', 'container/owner'], function (exports, _emberMetalProperty_get, _emberMetalRun_loop, _emberRuntimeSystemString, _emberRuntimeSystemNamespace, _emberRuntimeSystemObject, _emberRuntimeSystemNative_array, _emberApplicationSystemApplication, _containerOwner) {
  'use strict';

  /**
  @module ember
  @submodule ember-extension-support
  */

  /**
    The `DataAdapter` helps a data persistence library
    interface with tools that debug Ember such
    as the [Ember Extension](https://github.com/tildeio/ember-extension)
    for Chrome and Firefox.
  
    This class will be extended by a persistence library
    which will override some of the methods with
    library-specific code.
  
    The methods likely to be overridden are:
  
    * `getFilters`
    * `detect`
    * `columnsForType`
    * `getRecords`
    * `getRecordColumnValues`
    * `getRecordKeywords`
    * `getRecordFilterValues`
    * `getRecordColor`
    * `observeRecord`
  
    The adapter will need to be registered
    in the application's container as `dataAdapter:main`
  
    Example:
  
    ```javascript
    Application.initializer({
      name: "data-adapter",
  
      initialize: function(application) {
        application.register('data-adapter:main', DS.DataAdapter);
      }
    });
    ```
  
    @class DataAdapter
    @namespace Ember
    @extends EmberObject
    @public
  */
  exports.default = _emberRuntimeSystemObject.default.extend({
    init: function () {
      this._super.apply(this, arguments);
      this.releaseMethods = _emberRuntimeSystemNative_array.A();
    },

    /**
      The container-debug-adapter which is used
      to list all models.
       @property containerDebugAdapter
      @default undefined
      @since 1.5.0
      @public
    **/
    containerDebugAdapter: undefined,

    /**
      Number of attributes to send
      as columns. (Enough to make the record
      identifiable).
       @private
      @property attributeLimit
      @default 3
      @since 1.3.0
    */
    attributeLimit: 3,

    /**
       Ember Data > v1.0.0-beta.18
       requires string model names to be passed
       around instead of the actual factories.
        This is a stamp for the Ember Inspector
       to differentiate between the versions
       to be able to support older versions too.
        @public
       @property acceptsModelName
     */
    acceptsModelName: true,

    /**
      Stores all methods that clear observers.
      These methods will be called on destruction.
       @private
      @property releaseMethods
      @since 1.3.0
    */
    releaseMethods: _emberRuntimeSystemNative_array.A(),

    /**
      Specifies how records can be filtered.
      Records returned will need to have a `filterValues`
      property with a key for every name in the returned array.
       @public
      @method getFilters
      @return {Array} List of objects defining filters.
       The object should have a `name` and `desc` property.
    */
    getFilters: function () {
      return _emberRuntimeSystemNative_array.A();
    },

    /**
      Fetch the model types and observe them for changes.
       @public
      @method watchModelTypes
       @param {Function} typesAdded Callback to call to add types.
      Takes an array of objects containing wrapped types (returned from `wrapModelType`).
       @param {Function} typesUpdated Callback to call when a type has changed.
      Takes an array of objects containing wrapped types.
       @return {Function} Method to call to remove all observers
    */
    watchModelTypes: function (typesAdded, typesUpdated) {
      var _this = this;

      var modelTypes = this.getModelTypes();
      var releaseMethods = _emberRuntimeSystemNative_array.A();
      var typesToSend;

      typesToSend = modelTypes.map(function (type) {
        var klass = type.klass;
        var wrapped = _this.wrapModelType(klass, type.name);
        releaseMethods.push(_this.observeModelType(type.name, typesUpdated));
        return wrapped;
      });

      typesAdded(typesToSend);

      var release = function () {
        releaseMethods.forEach(function (fn) {
          return fn();
        });
        _this.releaseMethods.removeObject(release);
      };
      this.releaseMethods.pushObject(release);
      return release;
    },

    _nameToClass: function (type) {
      if (typeof type === 'string') {
        type = _containerOwner.getOwner(this)._lookupFactory('model:' + type);
      }
      return type;
    },

    /**
      Fetch the records of a given type and observe them for changes.
       @public
      @method watchRecords
       @param {String} modelName The model name
       @param {Function} recordsAdded Callback to call to add records.
      Takes an array of objects containing wrapped records.
      The object should have the following properties:
        columnValues: {Object} key and value of a table cell
        object: {Object} the actual record object
       @param {Function} recordsUpdated Callback to call when a record has changed.
      Takes an array of objects containing wrapped records.
       @param {Function} recordsRemoved Callback to call when a record has removed.
      Takes the following parameters:
        index: the array index where the records were removed
        count: the number of records removed
       @return {Function} Method to call to remove all observers
    */
    watchRecords: function (modelName, recordsAdded, recordsUpdated, recordsRemoved) {
      var _this2 = this;

      var releaseMethods = _emberRuntimeSystemNative_array.A();
      var klass = this._nameToClass(modelName);
      var records = this.getRecords(klass, modelName);
      var release;

      var recordUpdated = function (updatedRecord) {
        recordsUpdated([updatedRecord]);
      };

      var recordsToSend = records.map(function (record) {
        releaseMethods.push(_this2.observeRecord(record, recordUpdated));
        return _this2.wrapRecord(record);
      });

      var contentDidChange = function (array, idx, removedCount, addedCount) {
        for (var i = idx; i < idx + addedCount; i++) {
          var record = array.objectAt(i);
          var wrapped = _this2.wrapRecord(record);
          releaseMethods.push(_this2.observeRecord(record, recordUpdated));
          recordsAdded([wrapped]);
        }

        if (removedCount) {
          recordsRemoved(idx, removedCount);
        }
      };

      var observer = { didChange: contentDidChange, willChange: function () {
          return this;
        } };
      records.addArrayObserver(this, observer);

      release = function () {
        releaseMethods.forEach(function (fn) {
          fn();
        });
        records.removeArrayObserver(_this2, observer);
        _this2.releaseMethods.removeObject(release);
      };

      recordsAdded(recordsToSend);

      this.releaseMethods.pushObject(release);
      return release;
    },

    /**
      Clear all observers before destruction
      @private
      @method willDestroy
    */
    willDestroy: function () {
      this._super.apply(this, arguments);
      this.releaseMethods.forEach(function (fn) {
        fn();
      });
    },

    /**
      Detect whether a class is a model.
       Test that against the model class
      of your persistence library
       @private
      @method detect
      @param {Class} klass The class to test
      @return boolean Whether the class is a model class or not
    */
    detect: function (klass) {
      return false;
    },

    /**
      Get the columns for a given model type.
       @private
      @method columnsForType
      @param {Class} type The model type
      @return {Array} An array of columns of the following format:
       name: {String} name of the column
       desc: {String} Humanized description (what would show in a table column name)
    */
    columnsForType: function (type) {
      return _emberRuntimeSystemNative_array.A();
    },

    /**
      Adds observers to a model type class.
       @private
      @method observeModelType
      @param {String} modelName The model type name
      @param {Function} typesUpdated Called when a type is modified.
      @return {Function} The function to call to remove observers
    */

    observeModelType: function (modelName, typesUpdated) {
      var _this3 = this;

      var klass = this._nameToClass(modelName);
      var records = this.getRecords(klass, modelName);

      var onChange = function () {
        typesUpdated([_this3.wrapModelType(klass, modelName)]);
      };
      var observer = {
        didChange: function () {
          _emberMetalRun_loop.default.scheduleOnce('actions', this, onChange);
        },
        willChange: function () {
          return this;
        }
      };

      records.addArrayObserver(this, observer);

      var release = function () {
        records.removeArrayObserver(_this3, observer);
      };

      return release;
    },

    /**
      Wraps a given model type and observes changes to it.
       @private
      @method wrapModelType
      @param {Class} klass A model class
      @param {String} modelName Name of the class
      @return {Object} contains the wrapped type and the function to remove observers
      Format:
        type: {Object} the wrapped type
          The wrapped type has the following format:
            name: {String} name of the type
            count: {Integer} number of records available
            columns: {Columns} array of columns to describe the record
            object: {Class} the actual Model type class
        release: {Function} The function to remove observers
    */
    wrapModelType: function (klass, name) {
      var records = this.getRecords(klass, name);
      var typeToSend;

      typeToSend = {
        name: name,
        count: _emberMetalProperty_get.get(records, 'length'),
        columns: this.columnsForType(klass),
        object: klass
      };

      return typeToSend;
    },

    /**
      Fetches all models defined in the application.
       @private
      @method getModelTypes
      @return {Array} Array of model types
    */
    getModelTypes: function () {
      var _this4 = this;

      var containerDebugAdapter = this.get('containerDebugAdapter');
      var types;

      if (containerDebugAdapter.canCatalogEntriesByType('model')) {
        types = containerDebugAdapter.catalogEntriesByType('model');
      } else {
        types = this._getObjectsOnNamespaces();
      }

      // New adapters return strings instead of classes
      types = _emberRuntimeSystemNative_array.A(types).map(function (name) {
        return {
          klass: _this4._nameToClass(name),
          name: name
        };
      });
      types = _emberRuntimeSystemNative_array.A(types).filter(function (type) {
        return _this4.detect(type.klass);
      });

      return _emberRuntimeSystemNative_array.A(types);
    },

    /**
      Loops over all namespaces and all objects
      attached to them
       @private
      @method _getObjectsOnNamespaces
      @return {Array} Array of model type strings
    */
    _getObjectsOnNamespaces: function () {
      var _this5 = this;

      var namespaces = _emberRuntimeSystemNative_array.A(_emberRuntimeSystemNamespace.default.NAMESPACES);
      var types = _emberRuntimeSystemNative_array.A();

      namespaces.forEach(function (namespace) {
        for (var key in namespace) {
          if (!namespace.hasOwnProperty(key)) {
            continue;
          }
          // Even though we will filter again in `getModelTypes`,
          // we should not call `lookupFactory` on non-models
          // (especially when `Ember.MODEL_FACTORY_INJECTIONS` is `true`)
          if (!_this5.detect(namespace[key])) {
            continue;
          }
          var name = _emberRuntimeSystemString.dasherize(key);
          if (!(namespace instanceof _emberApplicationSystemApplication.default) && namespace.toString()) {
            name = namespace + '/' + name;
          }
          types.push(name);
        }
      });
      return types;
    },

    /**
      Fetches all loaded records for a given type.
       @private
      @method getRecords
      @return {Array} An array of records.
       This array will be observed for changes,
       so it should update when new records are added/removed.
    */
    getRecords: function (type) {
      return _emberRuntimeSystemNative_array.A();
    },

    /**
      Wraps a record and observers changes to it.
       @private
      @method wrapRecord
      @param {Object} record The record instance.
      @return {Object} The wrapped record. Format:
      columnValues: {Array}
      searchKeywords: {Array}
    */
    wrapRecord: function (record) {
      var recordToSend = { object: record };

      recordToSend.columnValues = this.getRecordColumnValues(record);
      recordToSend.searchKeywords = this.getRecordKeywords(record);
      recordToSend.filterValues = this.getRecordFilterValues(record);
      recordToSend.color = this.getRecordColor(record);

      return recordToSend;
    },

    /**
      Gets the values for each column.
       @private
      @method getRecordColumnValues
      @return {Object} Keys should match column names defined
      by the model type.
    */
    getRecordColumnValues: function (record) {
      return {};
    },

    /**
      Returns keywords to match when searching records.
       @private
      @method getRecordKeywords
      @return {Array} Relevant keywords for search.
    */
    getRecordKeywords: function (record) {
      return _emberRuntimeSystemNative_array.A();
    },

    /**
      Returns the values of filters defined by `getFilters`.
       @private
      @method getRecordFilterValues
      @param {Object} record The record instance
      @return {Object} The filter values
    */
    getRecordFilterValues: function (record) {
      return {};
    },

    /**
      Each record can have a color that represents its state.
       @private
      @method getRecordColor
      @param {Object} record The record instance
      @return {String} The record's color
        Possible options: black, red, blue, green
    */
    getRecordColor: function (record) {
      return null;
    },

    /**
      Observes all relevant properties and re-sends the wrapped record
      when a change occurs.
       @private
      @method observerRecord
      @param {Object} record The record instance
      @param {Function} recordUpdated The callback to call when a record is updated.
      @return {Function} The function to call to remove all observers.
    */
    observeRecord: function (record, recordUpdated) {
      return function () {};
    }
  });
});
enifed('ember-extension-support', ['exports', 'ember-metal/core', 'ember-extension-support/data_adapter', 'ember-extension-support/container_debug_adapter'], function (exports, _emberMetalCore, _emberExtensionSupportData_adapter, _emberExtensionSupportContainer_debug_adapter) {
  /**
  @module ember
  @submodule ember-extension-support
  */

  'use strict';

  _emberMetalCore.default.DataAdapter = _emberExtensionSupportData_adapter.default;
  _emberMetalCore.default.ContainerDebugAdapter = _emberExtensionSupportContainer_debug_adapter.default;
});
enifed('ember-htmlbars/compat', ['exports', 'ember-metal/core', 'ember-htmlbars/utils/string'], function (exports, _emberMetalCore, _emberHtmlbarsUtilsString) {
  'use strict';

  var EmberHandlebars = _emberMetalCore.default.Handlebars = _emberMetalCore.default.Handlebars || {};

  EmberHandlebars.SafeString = _emberHtmlbarsUtilsString.SafeString;
  EmberHandlebars.Utils = {
    escapeExpression: _emberHtmlbarsUtilsString.escapeExpression
  };

  exports.default = EmberHandlebars;
});
enifed('ember-htmlbars/env', ['exports', 'ember-metal', 'ember-metal/environment', 'htmlbars-runtime', 'ember-metal/assign', 'ember-htmlbars/hooks/subexpr', 'ember-htmlbars/hooks/concat', 'ember-htmlbars/hooks/link-render-node', 'ember-htmlbars/hooks/create-fresh-scope', 'ember-htmlbars/hooks/bind-shadow-scope', 'ember-htmlbars/hooks/bind-self', 'ember-htmlbars/hooks/bind-scope', 'ember-htmlbars/hooks/bind-local', 'ember-htmlbars/hooks/bind-block', 'ember-htmlbars/hooks/update-self', 'ember-htmlbars/hooks/get-root', 'ember-htmlbars/hooks/get-child', 'ember-htmlbars/hooks/get-block', 'ember-htmlbars/hooks/get-value', 'ember-htmlbars/hooks/get-cell-or-value', 'ember-htmlbars/hooks/cleanup-render-node', 'ember-htmlbars/hooks/destroy-render-node', 'ember-htmlbars/hooks/did-render-node', 'ember-htmlbars/hooks/will-cleanup-tree', 'ember-htmlbars/hooks/did-cleanup-tree', 'ember-htmlbars/hooks/classify', 'ember-htmlbars/hooks/component', 'ember-htmlbars/hooks/lookup-helper', 'ember-htmlbars/hooks/has-helper', 'ember-htmlbars/hooks/invoke-helper', 'ember-htmlbars/hooks/element', 'ember-htmlbars/helpers', 'ember-htmlbars/keywords', 'ember-htmlbars/system/dom-helper', 'ember-htmlbars/keywords/debugger', 'ember-htmlbars/keywords/with', 'ember-htmlbars/keywords/outlet', 'ember-htmlbars/keywords/unbound', 'ember-htmlbars/keywords/view', 'ember-htmlbars/keywords/component', 'ember-htmlbars/keywords/element-component', 'ember-htmlbars/keywords/partial', 'ember-htmlbars/keywords/input', 'ember-htmlbars/keywords/textarea', 'ember-htmlbars/keywords/collection', 'ember-htmlbars/keywords/yield', 'ember-htmlbars/keywords/legacy-yield', 'ember-htmlbars/keywords/mut', 'ember-htmlbars/keywords/each', 'ember-htmlbars/keywords/readonly', 'ember-htmlbars/keywords/get'], function (exports, _emberMetal, _emberMetalEnvironment, _htmlbarsRuntime, _emberMetalAssign, _emberHtmlbarsHooksSubexpr, _emberHtmlbarsHooksConcat, _emberHtmlbarsHooksLinkRenderNode, _emberHtmlbarsHooksCreateFreshScope, _emberHtmlbarsHooksBindShadowScope, _emberHtmlbarsHooksBindSelf, _emberHtmlbarsHooksBindScope, _emberHtmlbarsHooksBindLocal, _emberHtmlbarsHooksBindBlock, _emberHtmlbarsHooksUpdateSelf, _emberHtmlbarsHooksGetRoot, _emberHtmlbarsHooksGetChild, _emberHtmlbarsHooksGetBlock, _emberHtmlbarsHooksGetValue, _emberHtmlbarsHooksGetCellOrValue, _emberHtmlbarsHooksCleanupRenderNode, _emberHtmlbarsHooksDestroyRenderNode, _emberHtmlbarsHooksDidRenderNode, _emberHtmlbarsHooksWillCleanupTree, _emberHtmlbarsHooksDidCleanupTree, _emberHtmlbarsHooksClassify, _emberHtmlbarsHooksComponent, _emberHtmlbarsHooksLookupHelper, _emberHtmlbarsHooksHasHelper, _emberHtmlbarsHooksInvokeHelper, _emberHtmlbarsHooksElement, _emberHtmlbarsHelpers, _emberHtmlbarsKeywords, _emberHtmlbarsSystemDomHelper, _emberHtmlbarsKeywordsDebugger, _emberHtmlbarsKeywordsWith, _emberHtmlbarsKeywordsOutlet, _emberHtmlbarsKeywordsUnbound, _emberHtmlbarsKeywordsView, _emberHtmlbarsKeywordsComponent, _emberHtmlbarsKeywordsElementComponent, _emberHtmlbarsKeywordsPartial, _emberHtmlbarsKeywordsInput, _emberHtmlbarsKeywordsTextarea, _emberHtmlbarsKeywordsCollection, _emberHtmlbarsKeywordsYield, _emberHtmlbarsKeywordsLegacyYield, _emberHtmlbarsKeywordsMut, _emberHtmlbarsKeywordsEach, _emberHtmlbarsKeywordsReadonly, _emberHtmlbarsKeywordsGet) {
  'use strict';

  var emberHooks = _emberMetalAssign.default({}, _htmlbarsRuntime.hooks);
  emberHooks.keywords = _emberHtmlbarsKeywords.default;

  _emberMetalAssign.default(emberHooks, {
    linkRenderNode: _emberHtmlbarsHooksLinkRenderNode.default,
    createFreshScope: _emberHtmlbarsHooksCreateFreshScope.default,
    createChildScope: _emberHtmlbarsHooksCreateFreshScope.createChildScope,
    bindShadowScope: _emberHtmlbarsHooksBindShadowScope.default,
    bindSelf: _emberHtmlbarsHooksBindSelf.default,
    bindScope: _emberHtmlbarsHooksBindScope.default,
    bindLocal: _emberHtmlbarsHooksBindLocal.default,
    bindBlock: _emberHtmlbarsHooksBindBlock.default,
    updateSelf: _emberHtmlbarsHooksUpdateSelf.default,
    getBlock: _emberHtmlbarsHooksGetBlock.default,
    getRoot: _emberHtmlbarsHooksGetRoot.default,
    getChild: _emberHtmlbarsHooksGetChild.default,
    getValue: _emberHtmlbarsHooksGetValue.default,
    getCellOrValue: _emberHtmlbarsHooksGetCellOrValue.default,
    subexpr: _emberHtmlbarsHooksSubexpr.default,
    concat: _emberHtmlbarsHooksConcat.default,
    cleanupRenderNode: _emberHtmlbarsHooksCleanupRenderNode.default,
    destroyRenderNode: _emberHtmlbarsHooksDestroyRenderNode.default,
    willCleanupTree: _emberHtmlbarsHooksWillCleanupTree.default,
    didCleanupTree: _emberHtmlbarsHooksDidCleanupTree.default,
    didRenderNode: _emberHtmlbarsHooksDidRenderNode.default,
    classify: _emberHtmlbarsHooksClassify.default,
    component: _emberHtmlbarsHooksComponent.default,
    lookupHelper: _emberHtmlbarsHooksLookupHelper.default,
    hasHelper: _emberHtmlbarsHooksHasHelper.default,
    invokeHelper: _emberHtmlbarsHooksInvokeHelper.default,
    element: _emberHtmlbarsHooksElement.default
  });

  _emberHtmlbarsKeywords.registerKeyword('debugger', _emberHtmlbarsKeywordsDebugger.default);
  _emberHtmlbarsKeywords.registerKeyword('with', _emberHtmlbarsKeywordsWith.default);
  _emberHtmlbarsKeywords.registerKeyword('outlet', _emberHtmlbarsKeywordsOutlet.default);
  _emberHtmlbarsKeywords.registerKeyword('unbound', _emberHtmlbarsKeywordsUnbound.default);
  _emberHtmlbarsKeywords.registerKeyword('component', _emberHtmlbarsKeywordsComponent.default);
  _emberHtmlbarsKeywords.registerKeyword('@element_component', _emberHtmlbarsKeywordsElementComponent.default);
  _emberHtmlbarsKeywords.registerKeyword('partial', _emberHtmlbarsKeywordsPartial.default);
  _emberHtmlbarsKeywords.registerKeyword('input', _emberHtmlbarsKeywordsInput.default);
  _emberHtmlbarsKeywords.registerKeyword('textarea', _emberHtmlbarsKeywordsTextarea.default);
  _emberHtmlbarsKeywords.registerKeyword('yield', _emberHtmlbarsKeywordsYield.default);
  _emberHtmlbarsKeywords.registerKeyword('legacy-yield', _emberHtmlbarsKeywordsLegacyYield.default);
  _emberHtmlbarsKeywords.registerKeyword('mut', _emberHtmlbarsKeywordsMut.default);
  _emberHtmlbarsKeywords.registerKeyword('@mut', _emberHtmlbarsKeywordsMut.privateMut);
  _emberHtmlbarsKeywords.registerKeyword('each', _emberHtmlbarsKeywordsEach.default);
  _emberHtmlbarsKeywords.registerKeyword('readonly', _emberHtmlbarsKeywordsReadonly.default);
  _emberHtmlbarsKeywords.registerKeyword('get', _emberHtmlbarsKeywordsGet.default);

  if (_emberMetal.default.ENV._ENABLE_LEGACY_VIEW_SUPPORT) {
    _emberHtmlbarsKeywords.registerKeyword('collection', _emberHtmlbarsKeywordsCollection.default);
    _emberHtmlbarsKeywords.registerKeyword('view', _emberHtmlbarsKeywordsView.default);
  }

  exports.default = {
    hooks: emberHooks,
    helpers: _emberHtmlbarsHelpers.default,
    useFragmentCache: true
  };

  var domHelper = _emberMetalEnvironment.default.hasDOM ? new _emberHtmlbarsSystemDomHelper.default() : null;

  exports.domHelper = domHelper;
});
enifed('ember-htmlbars/glimmer-component', ['exports', 'ember-views/views/core_view', 'ember-views/mixins/view_child_views_support', 'ember-views/mixins/view_state_support', 'ember-views/mixins/template_rendering_support', 'ember-views/mixins/class_names_support', 'ember-views/mixins/instrumentation_support', 'ember-views/mixins/aria_role_support', 'ember-views/mixins/view_support', 'ember-views/views/view'], function (exports, _emberViewsViewsCore_view, _emberViewsMixinsView_child_views_support, _emberViewsMixinsView_state_support, _emberViewsMixinsTemplate_rendering_support, _emberViewsMixinsClass_names_support, _emberViewsMixinsInstrumentation_support, _emberViewsMixinsAria_role_support, _emberViewsMixinsView_support, _emberViewsViewsView) {
  'use strict';

  exports.default = _emberViewsViewsCore_view.default.extend(_emberViewsMixinsView_child_views_support.default, _emberViewsMixinsView_state_support.default, _emberViewsMixinsTemplate_rendering_support.default, _emberViewsMixinsClass_names_support.default, _emberViewsMixinsInstrumentation_support.default, _emberViewsMixinsAria_role_support.default, _emberViewsMixinsView_support.default, {
    isComponent: true,
    isGlimmerComponent: true,

    init: function () {
      this._super.apply(this, arguments);
      this._viewRegistry = this._viewRegistry || _emberViewsViewsView.default.views;
    }
  });
});
enifed('ember-htmlbars/helper', ['exports', 'ember-runtime/system/object'], function (exports, _emberRuntimeSystemObject) {
  /**
  @module ember
  @submodule ember-templates
  */

  'use strict';

  exports.helper = helper;

  /**
    Ember Helpers are functions that can compute values, and are used in templates.
    For example, this code calls a helper named `format-currency`:
  
    ```handlebars
    <div>{{format-currency cents currency="$"}}</div>
    ```
  
    Additionally a helper can be called as a nested helper (sometimes called a
    subexpression). In this example, the computed value of a helper is passed
    to a component named `show-money`:
  
    ```handlebars
    {{show-money amount=(format-currency cents currency="$")}}
    ```
  
    Helpers defined using a class must provide a `compute` function. For example:
  
    ```js
    export default Ember.Helper.extend({
      compute(params, hash) {
        let cents = params[0];
        let currency = hash.currency;
        return `${currency}${cents * 0.01}`;
      }
    });
    ```
  
    Each time the input to a helper changes, the `compute` function will be
    called again.
  
    As instances, these helpers also have access to the container an will accept
    injected dependencies.
  
    Additionally, class helpers can call `recompute` to force a new computation.
  
    @class Ember.Helper
    @public
    @since 1.13.0
  */
  var Helper = _emberRuntimeSystemObject.default.extend({
    isHelperInstance: true,

    /**
      On a class-based helper, it may be useful to force a recomputation of that
      helpers value. This is akin to `rerender` on a component.
       For example, this component will rerender when the `currentUser` on a
      session service changes:
       ```js
      // app/helpers/current-user-email.js
      export default Ember.Helper.extend({
        session: Ember.inject.service(),
        onNewUser: Ember.observer('session.currentUser', function() {
          this.recompute();
        }),
        compute() {
          return this.get('session.currentUser.email');
        }
      });
      ```
       @method recompute
      @public
      @since 1.13.0
    */
    recompute: function () {
      this._stream.notify();
    }

    /**
      Override this function when writing a class-based helper.
       @method compute
      @param {Array} params The positional arguments to the helper
      @param {Object} hash The named arguments to the helper
      @public
      @since 1.13.0
    */
  });

  Helper.reopenClass({
    isHelperFactory: true
  });

  /**
    In many cases, the ceremony of a full `Ember.Helper` class is not required.
    The `helper` method create pure-function helpers without instances. For
    example:
  
    ```js
    // app/helpers/format-currency.js
    export default Ember.Helper.helper(function(params, hash) {
      let cents = params[0];
      let currency = hash.currency;
      return `${currency}${cents * 0.01}`;
    });
    ```
  
    @static
    @param {Function} helper The helper function
    @method helper
    @public
    @since 1.13.0
  */

  function helper(helperFn) {
    return {
      isHelperInstance: true,
      compute: helperFn
    };
  }

  exports.default = Helper;
});
enifed('ember-htmlbars/helpers/-concat', ['exports'], function (exports) {
  /**
  @module ember
  @submodule ember-templates
  */

  /**
    Concatenates input params together.
  
    Example:
  
    ```handlebars
    {{some-component name=(concat firstName " " lastName)}}
  
    {{! would pass name="<first name value> <last name value>" to the component}}
    ```
  
    @public
    @method concat
    @for Ember.Templates.helpers
    @since 1.13.0
  */
  'use strict';

  exports.default = concat;

  function concat(params) {
    return params.join('');
  }
});
enifed('ember-htmlbars/helpers/-html-safe', ['exports', 'htmlbars-util/safe-string'], function (exports, _htmlbarsUtilSafeString) {
  'use strict';

  exports.default = htmlSafeHelper;

  /**
   This private helper is used internally to handle `isVisible: false` for
   Ember.View and Ember.Component.
  
   @private
   */

  function htmlSafeHelper(_ref) {
    var value = _ref[0];

    return new _htmlbarsUtilSafeString.default(value);
  }
});
enifed('ember-htmlbars/helpers/-join-classes', ['exports'], function (exports) {
  /*
    this private helper is used to join and compact a list of class names
  
    @private
  */

  'use strict';

  exports.default = joinClasses;

  function joinClasses(classNames) {
    var result = [];

    for (var i = 0, l = classNames.length; i < l; i++) {
      var className = classNames[i];

      if (className) {
        result.push(className);
      }
    }

    return result.join(' ');
  }
});
enifed('ember-htmlbars/helpers/-legacy-each-with-controller', ['exports', 'ember-metal/debug', 'ember-metal/property_get', 'ember-htmlbars/utils/normalize-self', 'ember-htmlbars/utils/decode-each-key'], function (exports, _emberMetalDebug, _emberMetalProperty_get, _emberHtmlbarsUtilsNormalizeSelf, _emberHtmlbarsUtilsDecodeEachKey) {
  'use strict';

  exports.default = legacyEachWithControllerHelper;

  function legacyEachWithControllerHelper(params, hash, blocks) {
    var list = params[0];
    var keyPath = hash.key;

    // TODO: Correct falsy semantics
    if (!list || _emberMetalProperty_get.get(list, 'length') === 0) {
      if (blocks.inverse.yield) {
        blocks.inverse.yield();
      }
      return;
    }

    list.forEach(function (item, i) {
      var self;

      if (blocks.template.arity === 0) {
        _emberMetalDebug.deprecate(deprecation, false, { id: 'ember-htmlbars.each-with-controller-helper', until: '2.4.0' });
        self = _emberHtmlbarsUtilsNormalizeSelf.default(item);
        self = bindController(self, true);
      }

      var key = _emberHtmlbarsUtilsDecodeEachKey.default(item, keyPath, i);
      blocks.template.yieldItem(key, [item, i], self);
    });
  }

  function bindController(controller, isSelf) {
    return {
      controller: controller,
      hasBoundController: true,
      self: controller ? controller : undefined
    };
  }

  var deprecation = 'Using the context switching form of {{each}} is deprecated. Please use the keyword form (`{{#each items as |item|}}`) instead.';
  exports.deprecation = deprecation;
});
enifed('ember-htmlbars/helpers/-legacy-each-with-keyword', ['exports', 'ember-views/streams/should_display', 'ember-htmlbars/utils/decode-each-key'], function (exports, _emberViewsStreamsShould_display, _emberHtmlbarsUtilsDecodeEachKey) {
  'use strict';

  exports.default = legacyEachWithKeywordHelper;

  function legacyEachWithKeywordHelper(params, hash, blocks) {
    var list = params[0];
    var keyPath = hash.key;
    var legacyKeyword = hash['-legacy-keyword'];

    if (_emberViewsStreamsShould_display.default(list)) {
      list.forEach(function (item, i) {
        var self;
        if (legacyKeyword) {
          self = bindKeyword(self, legacyKeyword, item);
        }

        var key = _emberHtmlbarsUtilsDecodeEachKey.default(item, keyPath, i);
        blocks.template.yieldItem(key, [item, i], self);
      });
    } else if (blocks.inverse.yield) {
      blocks.inverse.yield();
    }
  }

  function bindKeyword(self, keyword, item) {
    var _ref;

    return _ref = {
      self: self
    }, _ref[keyword] = item, _ref;
  }

  var deprecation = 'Using the context switching form of {{each}} is deprecated. Please use the keyword form (`{{#each items as |item|}}`) instead.';
  exports.deprecation = deprecation;
});
enifed('ember-htmlbars/helpers/-normalize-class', ['exports', 'ember-runtime/system/string', 'ember-metal/path_cache'], function (exports, _emberRuntimeSystemString, _emberMetalPath_cache) {
  'use strict';

  exports.default = normalizeClass;

  /*
    This private helper is used by ComponentNode to convert the classNameBindings
    microsyntax into a class name.
  
    When a component or view is created, we normalize class name bindings into a
    series of attribute nodes that use this helper.
  
    @private
  */

  function normalizeClass(params, hash) {
    var propName = params[0];
    var value = params[1];
    var activeClass = hash.activeClass;
    var inactiveClass = hash.inactiveClass;

    // When using the colon syntax, evaluate the truthiness or falsiness
    // of the value to determine which className to return
    if (activeClass || inactiveClass) {
      if (!!value) {
        return activeClass;
      } else {
        return inactiveClass;
      }

      // If value is a Boolean and true, return the dasherized property
      // name.
    } else if (value === true) {
        // Only apply to last segment in the path
        if (propName && _emberMetalPath_cache.isPath(propName)) {
          var segments = propName.split('.');
          propName = segments[segments.length - 1];
        }

        return _emberRuntimeSystemString.dasherize(propName);

        // If the value is not false, undefined, or null, return the current
        // value of the property.
      } else if (value !== false && value != null) {
          return value;

          // Nothing to display. Return null so that the old class is removed
          // but no new class is added.
        } else {
            return null;
          }
  }
});
enifed('ember-htmlbars/helpers/each-in', ['exports', 'ember-views/streams/should_display'], function (exports, _emberViewsStreamsShould_display) {
  /**
  @module ember
  @submodule ember-templates
  */

  'use strict';

  /**
    The `{{each-in}}` helper loops over properties on an object. It is unbound,
    in that new (or removed) properties added to the target object will not be
    rendered.
  
    For example, given a `user` object that looks like:
  
    ```javascript
    {
      "name": "Shelly Sails",
      "age": 42
    }
    ```
  
    This template would display all properties on the `user`
    object in a list:
  
    ```handlebars
    <ul>
    {{#each-in user as |key value|}}
      <li>{{key}}: {{value}}</li>
    {{/each-in}}
    </ul>
    ```
  
    Outputting their name and age.
  
    @method each-in
    @for Ember.Templates.helpers
    @public
    @since 2.1.0
  */
  var eachInHelper = function (_ref, hash, blocks) {
    var object = _ref[0];

    var objKeys, prop, i;
    objKeys = object ? Object.keys(object) : [];
    if (_emberViewsStreamsShould_display.default(objKeys)) {
      for (i = 0; i < objKeys.length; i++) {
        prop = objKeys[i];
        blocks.template.yieldItem(prop, [prop, object[prop]]);
      }
    } else if (blocks.inverse.yield) {
      blocks.inverse.yield();
    }
  };

  exports.default = eachInHelper;
});
enifed('ember-htmlbars/helpers/each', ['exports', 'ember-views/streams/should_display', 'ember-htmlbars/utils/decode-each-key'], function (exports, _emberViewsStreamsShould_display, _emberHtmlbarsUtilsDecodeEachKey) {
  /**
  @module ember
  @submodule ember-templates
  */

  'use strict';

  exports.default = eachHelper;

  /**
    The `{{#each}}` helper loops over elements in a collection. It is an extension
    of the base Handlebars `{{#each}}` helper.
  
    The default behavior of `{{#each}}` is to yield its inner block once for every
    item in an array passing the item as the first block parameter.
  
    ```javascript
    var developers = [{name: 'Yehuda'},{name: 'Tom'}, {name: 'Paul'}];
    ```
  
    ```handlebars
    {{#each developers key="name" as |person|}}
      {{person.name}}
      {{! `this` is whatever it was outside the #each }}
    {{/each}}
    ```
  
    The same rules apply to arrays of primitives.
  
    ```javascript
    var developerNames = ['Yehuda', 'Tom', 'Paul']
    ```
  
    ```handlebars
    {{#each developerNames key="@index" as |name|}}
      {{name}}
    {{/each}}
    ```
  
    During iteration, the index of each item in the array is provided as a second block parameter.
  
    ```handlebars
    <ul>
      {{#each people as |person index|}}
        <li>Hello, {{person.name}}! You're number {{index}} in line</li>
      {{/each}}
    </ul>
    ```
  
    ### Specifying Keys
  
    The `key` option is used to tell Ember how to determine if the array being
    iterated over with `{{#each}}` has changed between renders. By helping Ember
    detect that some elements in the array are the same, DOM elements can be
    re-used, significantly improving rendering speed.
  
    For example, here's the `{{#each}}` helper with its `key` set to `id`:
  
    ```handlebars
    {{#each model key="id" as |item|}}
    {{/each}}
    ```
  
    When this `{{#each}}` re-renders, Ember will match up the previously rendered
    items (and reorder the generated DOM elements) based on each item's `id`
    property.
  
    By default the item's own reference is used.
  
    ### {{else}} condition
  
    `{{#each}}` can have a matching `{{else}}`. The contents of this block will render
    if the collection is empty.
  
    ```handlebars
    {{#each developers as |person|}}
      {{person.name}}
    {{else}}
      <p>Sorry, nobody is available for this task.</p>
    {{/each}}
    ```
  
    @method each
    @for Ember.Templates.helpers
    @public
  */

  function eachHelper(params, hash, blocks) {
    var list = params[0];
    var keyPath = hash.key;

    if (_emberViewsStreamsShould_display.default(list)) {
      forEach(list, function (item, i) {
        var key = _emberHtmlbarsUtilsDecodeEachKey.default(item, keyPath, i);

        blocks.template.yieldItem(key, [item, i]);
      });
    } else if (blocks.inverse.yield) {
      blocks.inverse.yield();
    }
  }

  function forEach(iterable, cb) {
    return iterable.forEach ? iterable.forEach(cb) : Array.prototype.forEach.call(iterable, cb);
  }
});
enifed("ember-htmlbars/helpers/hash", ["exports"], function