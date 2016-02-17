				<h2>Công việc hiện có</h2>

				<div class="jobs">

					<!-- Job offer -->
					@foreach($job_pagi as $jobPost)
					<a href="/chi-tiet-cong-viec/{{$jobPost -> slug}}/{{date("d-m-Y", strtotime($jobPost -> post_at))}}">
						<div class="featured"></div>
						<img src="{{$jobPost->user->avatar}}" alt="{{$jobPost->title}}" class="img-circle" />
						<div class="title">
							<h5 style="width: 150px">
								{{$jobPost -> title}}
							</h5>
							<p>{{date("d-m-Y", strtotime($jobPost -> post_at))}}</p>
							<p>Đăng bởi: {{$jobPost->user->full_name}}
							</p> 

						</div>
						<div class="data">
							<span class="city"><i class="fa fa-map-marker"></i>{{$jobPost -> location}}</span>
							<span class="type full-time">
								<i class="fa fa-user"></i>Số lượng: {{ ($jobPost -> 	quantity)}}
							</span>
							<i class="fa fa-dollar"></i>{{ ($jobPost -> salary)}}
						</div>
					</a>
					@endforeach


				</div>

				<div class="paging_recruit">
					{!! $job_pagi->render() !!}
				</div>					

				