<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Model::unguard();

		$this->call('user');
	}

}


class JobPost extends Seeder
{
	public function run()
	{
		DB::table('job_post')->insert([
			array('job_cat'=>3,'job_title'=>'Tối ưu hoá angularjs','job_ddescription'=>'Chào các bạn.
			Mình đang làm 1 dự án sử dụng ionic để build app trên ios.
			Do app ngày càng lớn nên app ngày càng chậm. Trên các máy iphone 4 thì rất tệ.
			Nay mình muốn tìm 1 bạn chuyên gia về angularjs để giúp mình tối ưu hoá lại ứng dụng. Sao cho trên iphone4 cũng chạy mượt được.
			Không yêu cầu các bạn phải code lại mà yêu cầu các bạn chỉ ra các điểm yếu và phải xử lý như thế nào.','post_at'=>'2015-11-26 12:04:00','taken'=>'0','allowance_min'=>'500000','allowance_max'=>'2000000','location'=>'Hồ Chí Minh','user_post'=>'1'),
			
			array('job_cat'=>3,'job_title'=>'Tìm team phát triển trang web kinh doanh thực phẩm online','job_ddescription'=>'Cần tìm cá nhân hay team phát triển trang web kinh doanh thực phẩm online.

Thông tin này đã đăng 1 lần rồi nhưng do chưa tìm được đối tác như ý nên mình xin đăng lại với đầy đủ chi tiết hơn.

Yêu cầu:

1. Phát triển front-end và back-end theo tài liệu mô tả yêu cầu có sẵn.

2. Sử dụng MySQL, PHP. Cấu trúc DB do team thiết kế và cung cấp. Framework do team quyết định.

3. Trang web có sử dụng kỹ thuật đổi từ địa chỉ bình thường sang tọa độ GPS để xác định khoảng cách giữa khách hàng với các quầy giao dịch. Nếu team chưa có kinh nghiệm với kỹ thuật này thì có thể bỏ khỏi báo giá.

4. Deadline: front-end yêu cầu cuối tháng 12/2015 phải publish. Back-end và cả hệ thống đến cuối 1/2016 phải hoàn thành.

5. Cung cấp demo theo yêu cầu của mình. Demo này sẽ được trả phí bất kể đạt hay không đạt yêu cầu. 

6. Chi trả theo từng giai đoạn sau khi hoàn tất và test kiểm tra OK.

Thông tin chi tiết xin vui lòng inbox.

Cám ơn đã đọc tin','post_at'=>'2015-11-26 12:04:00','taken'=>'0','allowance_min'=>'500000','allowance_max'=>'2000000','location'=>'Hồ Chí Minh','user_post'=>'1'),
			
			array('job_cat'=>3,'job_title'=>'Cần xây dựng website dạng forum kết hợp bán hàng online.','job_ddescription'=>'Tôi đang cần tìm một coder để xây dựng website dạng forum kết hợp bán hàng online.

Do đây chưa phải là một website chuẩn nên sẽ xây dựng từng phần, khảo sát phản ứng của user và chỉnh sửa vài lần mới đi đến hoàn thiện.

Sẽ trao đổi cụ thể hơn khi tìm được coder.','post_at'=>'2015-11-26 12:04:00','taken'=>'0','allowance_min'=>'500000','allowance_max'=>'2000000','location'=>'Hồ Chí Minh','user_post'=>'1'),
			
			array('job_cat'=>3,'job_title'=>'website','job_ddescription'=>'mình đang làm 1 muốn làm 1 website kiểu về even

1. trả lời trắc nghiệp câu hỏi.

2. yêu cầu quay vòng xoay trúng thưởng http://www.cooky.vn/qua-tang kiểu giống trang này

3. kết quả ra minh có thể tính được kết quả trong lúc quay 

minh có rất nhiều even nên rất mong hợp tác với bạn nào làm có kinh nghiệm và đã làm web kiểu này rồi bạn nào có nhu cầu thì gửi báo giá cho mình nhé','post_at'=>'2015-11-26 12:04:00','taken'=>'0','allowance_min'=>'500000','allowance_max'=>'2000000','location'=>'Hồ Chí Minh','user_post'=>'1'),
			
			array('job_cat'=>3,'job_title'=>'Cần 1 bạn phát triển plugin cho wordpress','job_ddescription'=>'Hiện tại mình đang có 1 job về wp cần 1 bạn phát triển 1 số plugin cho wp

plugin của mình đơn giản

bạn nào có khả năng thi để lại thông tin cho mình nhé

Mình sẽ trao đổi lại

Cảm ơn các bạn đã quan tâm','post_at'=>'2015-11-26 12:04:00','taken'=>'0','allowance_min'=>'500000','allowance_max'=>'2000000','location'=>'Hồ Chí Minh','user_post'=>'1'),
		]);
	}
	
}

class user extends Seeder
{
	public function run()
	{
		DB::table('users')->insert([
			'id'=>1,'username'=>'hoangphucvu','full_name'=>'Hoàng Phúc Vũ','password'=>Hash::make(070695),'level'=>1,'active'=>1,'total_post'=>0
			
		]);
	}
	
}
/*`id_post`, `job_cat`, `job_title`, `job_sdescription`, `job_ddescription`, 
`post_at`, `taken`, `allowance_min`, `allowance_max`, 
`location`, `user_post`, `id_user_answer`
 `username`, `full_name`, `password`, `level`, `active`, `total_post`
*/