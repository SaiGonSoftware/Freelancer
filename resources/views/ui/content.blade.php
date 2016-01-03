@extends('ui.layout')
@section('content')
		<!-- ============ SLIDES START ============ -->
					@include('ui.slider')
		<!-- ============ SLIDES END ============ -->

		<!-- ============ JOBS START ============ -->

		<section id="jobs">
			<div class="container">
				<div class="row">

						<div class="col-sm-8">
							<h2>Công việc mới nhất</h2>
								<div class="jobs">
									@foreach($content as $jobPost)
										<a href="chi-tiet-cong-viec/{{$jobPost -> slug}}.html">
											<div class="featured"></div>
											<img src="/images/avatar.png" alt="" class="img-circle" style="width:100px;" />
											<div class="title">
												<h5 style="width: 150px">
												{{$jobPost -> title}}</h5>
												<p>{{date("d-m-Y", strtotime($jobPost -> post_at))}}</p>
												<p>Đăng bởi: {{$jobPost->user->full_name}}</p> 
												
											</div>
											<div class="data">
												<span class="city"><i class="fa fa-map-marker"></i>{{$jobPost -> location}}</span>
												<span class="type full-time">
												<i class="fa fa-clock-o"></i>
													@if ($jobPost->active==0)
														Công việc mở
													@else
													  	Đóng
													@endif
												</span>
												<span class="sallary">Chi Phí:<br>{{number_format ($jobPost -> allowance_min)."d"."-".number_format ($jobPost -> allowance_max)."d"}}</span>
											</div>
										</a>
									@endforeach
								</div>

							<a class="btn btn-primary" id="more-jobs" href="tim-viec.html">
								<!-- <span class="more">Show More Jobs <i class="fa fa-arrow-down"></i></span>
								<span class="less">Show Less Jobs <i class="fa fa-arrow-up"></i></span> -->
								<span class="">Xem thêm <i class="fa fa-arrow-down"></i></span>
							</a>

						</div>

					<div class="col-sm-4">
						<h2>Công việc hấp dẫn</h2>
						<a href="#">
							<img src="/images/featured-job.jpg" alt="Featured Job" class="img-responsive" />
							<div class="featured-job">
								<img src="images/job1.jpg" alt="" class="img-circle" />
								<div class="title">
									<h5>Web Designer</h5>
									<p>Amazon</p>
								</div>
								<div class="data">
									<span class="city"><i class="fa fa-map-marker"></i>New York City</span>
									<span class="type full-time"><i class="fa fa-clock-o"></i>Full Time</span>
									<span class="sallary"><i class="fa fa-dollar"></i>45,000</span>
								</div>
								<div class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tristique euismod lorem, a consequat orci consequat a. Donec ullamcorper tincidunt nunc, ut aliquam est pellentesque porta. In neque erat, malesuada sit amet orci ac, laoreet laoreet mauris.</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</section>

		<!-- ============ JOBS END ============ -->

		<!-- ============ COMPANIES START ============ -->

					@include('ui.companies')

		<!-- ============ COMPANIES END ============ -->

		<!-- ============ STATS START ============ -->

		<section id="stats" class="parallax text-center">
			<div class="tint"></div>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h1>Cho đến nay chúng tôi đã có</h1>
					</div>
				</div>
				<div class="row" id="counter">
					
					<div class="counter">
						<div class="number">{{$totalUser}}</div>
						<div class="description">Members</div>
					</div>
				
					<div class="counter">
						<div class="number">{{$totalJob}}</div>
						<div class="description">Jobs</div>
					</div>
				
					<div class="counter">
						<div class="number">1,482</div>
						<div class="description">Resumes</div>
					</div>
				
					<div class="counter">
						<div class="number">83</div>
						<div class="description">Companies</div>
					</div>

				</div>
				<div class="row">
					<div class="col-sm-12">
						<p><a class="link-register btn btn-primary">Join Us</a></p>
					</div>
				</div>
			</div>
		</section>

		<!-- ============ STATS END ============ -->

		<!-- ============ BLOG START ============ -->

		<section id="blog" class="color3">
			<div class="container">
				<div class="row text-center">
					<div class="col-sm-12">
						<h1>Latest News</h1>
						<h4>Specially crafted job posts everyday</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="owl-carousel">

							<!-- Blog post 1 -->
							<div>
								<img src="images/blog1.jpg" class="img-responsive" alt="Blog Post" />
								<h4>Lorem ipsum dolor sit amet</h4>
								<h5>
									<span><i class="fa fa-calendar"></i>28.08.2015</span>
									<span><i class="fa fa-comment"></i>8 Comments</span>
								</h5>
								<p>Consectetur adipiscing elit. Duis lobortis tincidunt pretium. Suspendisse ullamcorper quis neque quis viverra. Cras ut leo in lectus gravida fringilla. In hac habitasse platea dictumst. Fusce facilisis sapien dolor, non fermentum magna tempus ac. Fusce quis eros sit amet magna aliquam euismod ac eget libero. Fusce accumsan in eros vitae posuere.</p>
								<p><a href="post.html" class="btn btn-primary">Read more</a></p>
							</div>

							<!-- Blog post 2 -->
							<div>
								<img src="images/blog2.jpg" class="img-responsive" alt="Blog Post" />
								<h4>Lorem ipsum dolor sit amet</h4>
								<h5>
									<span><i class="fa fa-calendar"></i>28.08.2015</span>
									<span><i class="fa fa-comment"></i>8 Comments</span>
								</h5>
								<p>Consectetur adipiscing elit. Duis lobortis tincidunt pretium. Suspendisse ullamcorper quis neque quis viverra. Cras ut leo in lectus gravida fringilla. In hac habitasse platea dictumst. Fusce facilisis sapien dolor, non fermentum magna tempus ac. Fusce quis eros sit amet magna aliquam euismod ac eget libero. Fusce accumsan in eros vitae posuere.</p>
								<p><a href="post.html" class="btn btn-primary">Read more</a></p>
							</div>

							<!-- Blog post 3 -->
							<div>
								<img src="images/blog3.jpg" class="img-responsive" alt="Blog Post" />
								<h4>Lorem ipsum dolor sit amet</h4>
								<h5>
									<span><i class="fa fa-calendar"></i>28.08.2015</span>
									<span><i class="fa fa-comment"></i>8 Comments</span>
								</h5>
								<p>Consectetur adipiscing elit. Duis lobortis tincidunt pretium. Suspendisse ullamcorper quis neque quis viverra. Cras ut leo in lectus gravida fringilla. In hac habitasse platea dictumst. Fusce facilisis sapien dolor, non fermentum magna tempus ac. Fusce quis eros sit amet magna aliquam euismod ac eget libero. Fusce accumsan in eros vitae posuere.</p>
								<p><a href="post.html" class="btn btn-primary">Read more</a></p>
							</div>

							<!-- Blog post 4 -->
							<div>
								<img src="images/blog4.jpg" class="img-responsive" alt="Blog Post" />
								<h4>Lorem ipsum dolor sit amet</h4>
								<h5>
									<span><i class="fa fa-calendar"></i>28.08.2015</span>
									<span><i class="fa fa-comment"></i>8 Comments</span>
								</h5>
								<p>Consectetur adipiscing elit. Duis lobortis tincidunt pretium. Suspendisse ullamcorper quis neque quis viverra. Cras ut leo in lectus gravida fringilla. In hac habitasse platea dictumst. Fusce facilisis sapien dolor, non fermentum magna tempus ac. Fusce quis eros sit amet magna aliquam euismod ac eget libero. Fusce accumsan in eros vitae posuere.</p>
								<p><a href="post.html" class="btn btn-primary">Read more</a></p>
							</div>

							<!-- Blog post 5 -->
							<div>
								<img src="images/blog5.jpg" class="img-responsive" alt="Blog Post" />
								<h4>Lorem ipsum dolor sit amet</h4>
								<h5>
									<span><i class="fa fa-calendar"></i>28.08.2015</span>
									<span><i class="fa fa-comment"></i>8 Comments</span>
								</h5>
								<p>Consectetur adipiscing elit. Duis lobortis tincidunt pretium. Suspendisse ullamcorper quis neque quis viverra. Cras ut leo in lectus gravida fringilla. In hac habitasse platea dictumst. Fusce facilisis sapien dolor, non fermentum magna tempus ac. Fusce quis eros sit amet magna aliquam euismod ac eget libero. Fusce accumsan in eros vitae posuere.</p>
								<p><a href="post.html" class="btn btn-primary">Read more</a></p>
							</div>

						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- ============ BLOG END ============ -->

		<!-- ============ PEOPLE START ============ -->
					@include('ui.people')
		<!-- ============ PEOPLE END ============ -->
		<!-- ============ CLIENTS START ============ -->
				        @include('ui.client')
		<!-- ============ CLIENTS END ============ -->
		
@stop