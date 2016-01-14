						<div class="jobs">
							
							<!-- Job offer -->
							@foreach($job_pagi as $jobPost)
							<a href="chi-tiet-cong-viec/{{$jobPost -> slug}}/{{date("d-m-Y", strtotime($jobPost -> post_at))}}">
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
											<i class="fa fa-clock-o"></i>
													@if ($jobPost->taken==0)
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

					<div class="paging_job">
						{!! $job_pagi->render() !!}
					</div>	