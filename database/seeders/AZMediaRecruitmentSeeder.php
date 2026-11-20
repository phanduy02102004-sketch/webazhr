<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Admin;
use App\Models\InternshipPosition;
use App\Models\Candidate;
use App\Models\Application;
use App\Models\TestQuestion;
use App\Models\CandidateTest;
use App\Models\Evaluation;
use App\Models\EmailTemplate;
use App\Models\EmailLog;

class AZMediaRecruitmentSeeder extends Seeder
{
    public function run()
    {
        // 1. Roles
        $roles = [
            ['name' => 'admin', 'display_name' => 'Quản trị viên Hệ thống', 'description' => 'Toàn quyền quản trị cấu hình, tài khoản và xem báo cáo tổng quan'],
            ['name' => 'hr', 'display_name' => 'Chuyên viên Tuyển dụng (HR)', 'description' => 'Quản lý tin tuyển dụng, lọc hồ sơ, điều phối phỏng vấn, gửi email tự động'],
            ['name' => 'mentor', 'display_name' => 'Cán bộ Chuyên môn (Mentor / Tech Lead)', 'description' => 'Sàng lọc CV kỹ thuật, chấm bài test, phỏng vấn và nhập Scorecard đánh giá'],
            ['name' => 'candidate', 'display_name' => 'Ứng viên / Thực tập sinh', 'description' => 'Nộp hồ sơ, tra cứu tiến độ và làm bài test online'],
        ];

        foreach ($roles as $r) {
            Role::updateOrCreate(['name' => $r['name']], $r);
        }

        // 2. Internal Users (Admins / HR / Mentor)
        $admins = [
            [
                'name' => 'Lê Đình Quang (Tổng Giám Đốc)',
                'email' => 'admin@azmedia.com.vn',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'name' => 'Trần Thị Mai Phương (HR Lead)',
                'email' => 'hr@azmedia.com.vn',
                'password' => Hash::make('12345678'),
                'role' => 'hr',
                'status' => 'active',
            ],
            [
                'name' => 'ThS. Đặng Quý Linh (Tech Lead / Mentor)',
                'email' => 'mentor@azmedia.com.vn',
                'password' => Hash::make('12345678'),
                'role' => 'mentor',
                'status' => 'active',
            ]
        ];

        foreach ($admins as $adm) {
            Admin::updateOrCreate(['email' => $adm['email']], $adm);
        }

        // Cập nhật tài khoản admin@gmail.com có sẵn thành admin
        Admin::where('email', 'admin@gmail.com')->update(['role' => 'admin']);

        $mentorUser = Admin::where('email', 'mentor@azmedia.com.vn')->first();
        $hrUser = Admin::where('email', 'hr@azmedia.com.vn')->first();

        // 3. Internship Positions (Vị trí thực tập sinh AZ Media)
        $positions = [
            [
                'title' => 'Thực tập sinh Lập trình Web Backend (PHP / Laravel / MySQL)',
                'slug' => 'tts-backend-php-laravel',
                'department' => 'Công nghệ Thông tin',
                'category' => 'backend',
                'location' => '84 Nguyễn Hữu Dật, Hải Châu, Đà Nẵng',
                'type' => 'part_time',
                'quantity' => 5,
                'stipend' => '3.500.000đ - 6.000.000đ / tháng + Thưởng dự án',
                'experience_required' => 'Không yêu cầu kinh nghiệm, ưu tiên sinh viên năm 3, 4 hoặc mới tốt nghiệp ngành CNTT/KTPM',
                'summary' => 'Tham gia phát triển hệ thống quản trị, RESTful API và các nền tảng chuyển đổi số trực tiếp tại chi nhánh AZ Media Đà Nẵng dưới sự hướng dẫn 1-1 của Tech Lead.',
                'description' => "VAI TRÒ CÔNG VIỆC:\n- Được đào tạo bài bản về kiến trúc Laravel Framework nâng cao, Repository Pattern, RESTful API, tối ưu hóa CSDL MySQL.\n- Tham gia xây dựng các module cho hệ thống nội bộ Mini-ATS, CRM và các dự án khách hàng của AZ Media.\n- Được hướng dẫn quy trình Git workflow, Clean Code, bảo mật hệ thống và triển khai thực tế trên máy chủ.\n- Làm việc trong môi trường năng động với văn hóa 'Thầy giỏi - Bạn tốt - Sách hay'.",
                'requirements' => "- Nắm vững kiến thức nền tảng về lập trình hướng đối tượng (OOP), ngôn ngữ PHP và cơ sở dữ liệu MySQL.\n- Đã từng làm qua đồ án hoặc dự án học tập với Laravel Framework là lợi thế lớn.\n- Tinh thần chủ động, ham học hỏi theo tôn chỉ 'Học lý thuyết để nắm rõ bản chất, hành động để thành công' (Giá trị cốt lõi A - Action của AZ Media).\n- Có laptop cá nhân phục vụ công việc thực tập.",
                'benefits' => "- Hỗ trợ phụ cấp thực tập từ 3.500.000đ - 6.000.000đ/tháng dựa trên năng lực và đóng góp.\n- Được Mentor Lê Đình Quang và các Senior Developer kèm cặp 1-1 ('Thầy giỏi').\n- Cung cấp dấu mộc tròn pháp nhân của Công ty TNHH Đầu tư Phát triển Doanh nghiệp AZ Homes - Chi nhánh AZ Media phục vụ báo cáo thực tập tốt nghiệp.\n- Cơ hội được ký hợp đồng nhân viên chính thức ngay sau 3 tháng hoàn thành kỳ thực tập.\n- Tham gia các hoạt động teambuilding, workshop truyền thông số, Happy Hour hàng tuần.",
                'mentor_name' => 'Lê Đình Quang',
                'deadline' => '2026-12-31',
                'is_featured' => true,
                'status' => 'open',
            ],
            [
                'title' => 'Thực tập sinh Lập trình Web Frontend (Vue.js / React / Tailwind CSS)',
                'slug' => 'tts-frontend-vue-react',
                'department' => 'Công nghệ Thông tin',
                'category' => 'frontend',
                'location' => '84 Nguyễn Hữu Dật, Hải Châu, Đà Nẵng',
                'type' => 'part_time',
                'quantity' => 4,
                'stipend' => '3.000.000đ - 5.500.000đ / tháng + Thưởng dự án',
                'experience_required' => 'Ưu tiên sinh viên các trường Cao đẳng Đà Nẵng, ĐHBK, VKU, Duy Tân',
                'summary' => 'Xây dựng giao diện Single Page Application (SPA), Landing Page tối ưu UX/UI và Mobile-First cho các chiến dịch truyền thông đa kênh.',
                'description' => "VAI TRÒ CÔNG VIỆC:\n- Cắt giao diện từ thiết kế Figma sang HTML5/CSS3/Tailwind CSS chuẩn Responsive trên mọi thiết bị di động.\n- Xây dựng Single Page Application hiện đại tương tác với RESTful API.\n- Tối ưu hóa tốc độ tải trang dưới 2 giây và trải nghiệm người dùng Mobile-First.",
                'requirements' => "- Thành thạo HTML5, CSS3, JavaScript (ES6+).\n- Có kiến thức hoặc từng làm quen với React, Vue.js hoặc Blade Template + Tailwind CSS.\n- Tư duy thẩm mỹ tốt, tỉ mỉ trong từng pixel giao diện.",
                'benefits' => "- Phụ cấp hàng tháng + Thưởng KPI theo tiến độ dự án.\n- Môi trường làm việc mở, trẻ trung, trang thiết bị hiện đại.\n- Hỗ trợ số liệu và dấu mộc xác nhận báo cáo thực tập.",
                'mentor_name' => 'Lê Đình Quang',
                'deadline' => '2026-12-31',
                'is_featured' => true,
                'status' => 'open',
            ],
            [
                'title' => 'Thực tập sinh Kiểm thử Phần mềm (QA / QC / Tester)',
                'slug' => 'tts-tester-qa-qc',
                'department' => 'Đảm bảo Chất lượng Phần mềm',
                'category' => 'tester',
                'location' => '84 Nguyễn Hữu Dật, Hải Châu, Đà Nẵng',
                'type' => 'part_time',
                'quantity' => 3,
                'stipend' => '3.000.000đ - 4.500.000đ / tháng',
                'experience_required' => 'Không yêu cầu kinh nghiệm, cẩn thận, chi tiết',
                'summary' => 'Viết Test case, thực hiện Manual Testing, báo cáo lỗi và đồng hành đảm bảo chất lượng các ứng dụng phần mềm tại AZ Media.',
                'description' => "VAI TRÒ CÔNG VIỆC:\n- Đọc hiểu tài liệu yêu cầu (SRS, User Stories), lập kế hoạch kiểm thử và viết Test Cases.\n- Thực hiện kiểm thử chức năng (Functional Testing), giao diện (UI Testing), hiệu năng cơ bản trên web và mobile.\n- Ghi nhận lỗi trên hệ thống quản lý Bug và phối hợp với đội Dev để xử lý triệt để.",
                'requirements' => "- Nắm vững quy trình kiểm thử phần mềm cơ bản (STLC, Bug Lifecycle).\n- Kỹ năng tư duy logic và kiểm thử tỉ mỉ.\n- Khả năng giao tiếp và làm việc nhóm tốt.",
                'benefits' => "- Hỗ trợ phụ cấp và chứng nhận thực tập chuẩn chỉ.\n- Đào tạo kỹ năng viết Test Case chuyên nghiệp và làm quen Automation Test (Postman, Cypress).",
                'mentor_name' => 'Lê Đình Quang',
                'deadline' => '2026-12-31',
                'is_featured' => false,
                'status' => 'open',
            ],
            [
                'title' => 'Thực tập sinh Thiết kế UI/UX & Đồ họa Truyền thông',
                'slug' => 'tts-ui-ux-graphic-designer',
                'department' => 'Thiết kế & Sáng tạo Số',
                'category' => 'uiux',
                'location' => '84 Nguyễn Hữu Dật, Hải Châu, Đà Nẵng',
                'type' => 'part_time',
                'quantity' => 3,
                'stipend' => '3.000.000đ - 5.000.000đ / tháng',
                'experience_required' => 'Có portfolio thiết kế (Behance, Figma hoặc Google Drive)',
                'summary' => 'Thiết kế giao diện ứng dụng web/mobile và các ấn phẩm nhận diện thương hiệu truyền thông số cho các khóa đào tạo AZ Media.',
                'description' => "VAI TRÒ CÔNG VIỆC:\n- Nghiên cứu trải nghiệm người dùng, xây dựng Wireframe, Prototype trên Figma.\n- Thiết kế banner, poster, thumbnail mạng xã hội (Facebook, TikTok, Threads) đồng nhất nhận diện AZ Media.\n- Phối hợp chặt chẽ với Frontend Dev để hiện thực hóa thiết kế.",
                'requirements' => "- Sử dụng tốt Figma, Photoshop, Illustrator hoặc Canva Pro.\n- Hiểu biết về nguyên lý bố cục, màu sắc, typography và User Experience.\n- Có portfolio đính kèm khi ứng tuyển.",
                'benefits' => "- Phụ cấp thực tập + tham gia các dự án nhận diện thương hiệu lớn.\n- Mentor góp ý và nâng cấp Portfolio cá nhân chuyên nghiệp.",
                'mentor_name' => 'Lê Đình Quang',
                'deadline' => '2026-12-31',
                'is_featured' => false,
                'status' => 'open',
            ],
            [
                'title' => 'Thực tập sinh Digital Marketing & Quản trị Kênh Số (TikTok, Threads, FB)',
                'slug' => 'tts-digital-marketing-media',
                'department' => 'Marketing & Truyền thông Số',
                'category' => 'marketing',
                'location' => '84 Nguyễn Hữu Dật, Hải Châu, Đà Nẵng',
                'type' => 'part_time',
                'quantity' => 5,
                'stipend' => '3.000.000đ - 5.500.000đ / tháng + Thưởng chuyển đổi',
                'experience_required' => 'Đam mê sáng tạo nội dung, bắt trend nhanh',
                'summary' => 'Phát triển các kênh truyền thông số triệu view của AZ Media: TikTok @ctyazmedia, Fanpage, Threads, hỗ trợ tư vấn chiến lược cho hơn 300 doanh nghiệp.',
                'description' => "VAI TRÒ CÔNG VIỆC:\n- Sáng tạo nội dung video ngắn, kịch bản reels/tiktok về kiến thức khởi nghiệp, kinh doanh số và marketing.\n- Hỗ trợ vận hành các chiến dịch quảng cáo đa kênh (Meta Ads, TikTok Ads, Google Search).\n- Thực hành tư vấn chiến lược marketing thực chiến theo mô hình A-Z-M của AZ Media.",
                'requirements' => "- Yêu thích marketing online, có khả năng viết lách hoặc quay dựng video capcut cơ bản.\n- Năng động, bắt trend nhạy bén trên mạng xã hội.\n- Thái độ tích cực, dám nghĩ dám làm.",
                'benefits' => "- Được tiếp cận hàng trăm chiến lược marketing thực chiến đã tư vấn cho hơn 300 doanh nghiệp.\n- Tiếp xúc và học hỏi trực tiếp từ Tổng Giám Đốc Lê Đình Quang.\n- Đào tạo kỹ năng chạy Ads và tối ưu hóa chuyển đổi số chuyên sâu.",
                'mentor_name' => 'Lê Đình Quang',
                'deadline' => '2026-12-31',
                'is_featured' => true,
                'status' => 'open',
            ],
            [
                'title' => 'Thực tập sinh Ứng dụng AI & Tự động hóa Doanh nghiệp (AI Solutions Intern)',
                'slug' => 'tts-ai-automation-solutions',
                'department' => 'Nghiên cứu & Giải pháp AI',
                'category' => 'ai',
                'location' => '84 Nguyễn Hữu Dật, Hải Châu, Đà Nẵng',
                'type' => 'part_time',
                'quantity' => 2,
                'stipend' => '4.000.000đ - 7.000.000đ / tháng',
                'experience_required' => 'Đam mê Generative AI, Prompt Engineering, Automation workflows',
                'summary' => 'Nghiên cứu và ứng dụng các công cụ Trí tuệ Nhân tạo (AI), xây dựng chatbot và quy trình tự động hóa quy trình nghiệp vụ cho đối tác.',
                'description' => "VAI TRÒ CÔNG VIỆC:\n- Xây dựng quy trình tự động hóa bằng AI (Make, Zapier, n8n, OpenAI/Claude API).\n- Nghiên cứu giải pháp AI phục vụ tối ưu hóa vận hành và marketing doanh nghiệp.\n- Hiện thực hóa giá trị cốt lõi 'Trí tuệ' - ứng dụng AI đón đầu xu hướng tại AZ Media.",
                'requirements' => "- Đam mê và thường xuyên ứng dụng AI (ChatGPT, Claude, Midjourney...).\n- Có kiến thức lập trình Python hoặc JavaScript/NodeJS là điểm cộng lớn.",
                'benefits' => "- Phụ cấp cạnh tranh, thưởng dự án theo sản phẩm tự động hóa.\n- Cơ hội tham gia nghiên cứu và giảng dạy tại Học viện Khởi nghiệp AZ Media trong tương lai.",
                'mentor_name' => 'Lê Đình Quang',
                'deadline' => '2026-12-31',
                'is_featured' => true,
                'status' => 'open',
            ],
        ];

        $posRecords = [];
        foreach ($positions as $p) {
            $posRecords[$p['category']] = InternshipPosition::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // 4. Test Questions (Ngân hàng câu hỏi trắc nghiệm đánh giá năng lực)
        $questions = [
            // Backend questions
            [
                'position_category' => 'backend',
                'position_id' => $posRecords['backend']->id,
                'question' => 'Trong Laravel, Middleware thường được sử dụng cho mục đích nào sau đây?',
                'option_a' => 'Truy vấn cơ sở dữ liệu và xử lý quan hệ giữa các bảng.',
                'option_b' => 'Lọc và kiểm tra các yêu cầu HTTP (HTTP Requests) trước khi đến Controller.',
                'option_c' => 'Render giao diện HTML và nén file CSS/JS.',
                'option_d' => 'Khởi tạo cấu trúc bảng thông qua cơ chế Migrations.',
                'correct_option' => 'B',
                'explanation' => 'Middleware trong Laravel hoạt động như một tầng trung gian kiểm tra HTTP request (ví dụ: kiểm tra quyền đăng nhập, xác thực token, kiểm tra CSRF) trước khi chuyển request đến controller tương ứng.',
                'difficulty' => 'easy',
                'points' => 10,
            ],
            [
                'position_category' => 'backend',
                'position_id' => $posRecords['backend']->id,
                'question' => 'Sự khác biệt cốt lõi giữa phương thức GET và POST trong giao thức HTTP là gì?',
                'option_a' => 'GET chỉ dùng để gửi mật khẩu, POST dùng để lấy dữ liệu.',
                'option_b' => 'GET truyền tham số qua URL Query String và có tính Idempotent; POST truyền qua Request Body và thường làm thay đổi trạng thái server.',
                'option_c' => 'GET không thể đính kèm dữ liệu, POST chỉ đính kèm file XML.',
                'option_d' => 'GET luôn chạy chậm hơn POST do cơ chế nén dữ liệu gzip.',
                'correct_option' => 'B',
                'explanation' => 'GET truyền dữ liệu hiển thị trên URL, an toàn cho việc tra cứu và có thể cache; POST truyền qua Request Body, an toàn và dùng khi tạo mới hoặc cập nhật dữ liệu.',
                'difficulty' => 'medium',
                'points' => 10,
            ],
            [
                'position_category' => 'backend',
                'position_id' => $posRecords['backend']->id,
                'question' => 'Trong quan hệ Eloquent ORM của Laravel, phương thức nào biểu diễn quan hệ Một - Nhiều (One-to-Many) ở Model cha?',
                'option_a' => 'belongsTo()',
                'option_b' => 'hasMany()',
                'option_c' => 'belongsToMany()',
                'option_d' => 'hasOneThrough()',
                'correct_option' => 'B',
                'explanation' => 'Model cha định nghĩa quan hệ Một - Nhiều tới Model con thông qua phương thức hasMany().',
                'difficulty' => 'easy',
                'points' => 10,
            ],
            [
                'position_category' => 'backend',
                'position_id' => $posRecords['backend']->id,
                'question' => 'Để ngăn chặn lỗ hổng SQL Injection khi viết truy vấn trong PHP/Laravel, giải pháp chuẩn nhất là gì?',
                'option_a' => 'Chỉ sử dụng phương thức mã hóa md5 cho chuỗi SQL.',
                'option_b' => 'Sử dụng Prepared Statements kết hợp Parameter Binding (như PDO / Eloquent Query Builder).',
                'option_c' => 'Nối chuỗi trực tiếp giá trị người dùng vào câu lệnh SQL SELECT.',
                'option_d' => 'Tắt thông báo lỗi trên file php.ini.',
                'correct_option' => 'B',
                'explanation' => 'Prepared Statements với Parameter Binding tách biệt mã lệnh SQL và dữ liệu đầu vào của người dùng, triệt tiêu hoàn toàn nguy cơ SQL Injection.',
                'difficulty' => 'medium',
                'points' => 10,
            ],
            [
                'position_category' => 'backend',
                'position_id' => $posRecords['backend']->id,
                'question' => 'Mã trạng thái HTTP 401 Unauthorized có ý nghĩa gì trong RESTful API?',
                'option_a' => 'Tài nguyên yêu cầu không tồn tại trên hệ thống.',
                'option_b' => 'Máy chủ gặp lỗi nội bộ không thể xử lý yêu cầu.',
                'option_c' => 'Yêu cầu thiếu thông tin xác thực danh tính hợp lệ hoặc token đã hết hạn.',
                'option_d' => 'Yêu cầu đã được xử lý thành công nhưng không có nội dung trả về.',
                'correct_option' => 'C',
                'explanation' => '401 Unauthorized báo hiệu client cần đăng nhập hoặc cung cấp Bearer token xác thực hợp lệ.',
                'difficulty' => 'easy',
                'points' => 10,
            ],

            // Frontend questions
            [
                'position_category' => 'frontend',
                'position_id' => $posRecords['frontend']->id,
                'question' => 'Khái niệm "Virtual DOM" (DOM ảo) trong các thư viện hiện đại như React hay Vue mang lại lợi ích gì?',
                'option_a' => 'Tự động tạo ra cơ sở dữ liệu trên trình duyệt máy khách.',
                'option_b' => 'Giảm thiểu việc thao tác trực tiếp lên Real DOM bằng thuật toán so khớp Diffing, giúp tối ưu hiệu năng render.',
                'option_c' => 'Thay thế hoàn toàn mã JavaScript bằng WebAssembly.',
                'option_d' => 'Mã hóa giao diện ngăn chặn việc xem mã nguồn Inspect Element.',
                'correct_option' => 'B',
                'explanation' => 'Virtual DOM là bản sao bằng JavaScript Object trong bộ nhớ; khi state thay đổi, cơ chế diffing tìm các thay đổi nhỏ nhất rồi mới cập nhật vào Real DOM.',
                'difficulty' => 'medium',
                'points' => 10,
            ],
            [
                'position_category' => 'frontend',
                'position_id' => $posRecords['frontend']->id,
                'question' => 'Trong thiết kế Responsive Web theo chuẩn Mobile-First, nguyên tắc cơ bản nhất là gì?',
                'option_a' => 'Thiết kế cho màn hình Desktop độ phân giải 4K trước, sau đó dùng JavaScript ẩn bớt phần tử trên điện thoại.',
                'option_b' => 'Viết CSS cho màn hình điện thoại di động trước với @media (min-width: ...), sau đó mở rộng dần cho Tablet và Desktop.',
                'option_c' => 'Xây dựng 2 website hoàn toàn độc lập với 2 tên miền khác nhau.',
                'option_d' => 'Không sử dụng thẻ meta viewport.',
                'correct_option' => 'B',
                'explanation' => 'Mobile-First ưu tiên viết CSS mặc định cho màn hình nhỏ, sau đó dùng các media query min-width để mở rộng hiển thị cho các màn hình lớn hơn.',
                'difficulty' => 'easy',
                'points' => 10,
            ],
            [
                'position_category' => 'frontend',
                'position_id' => $posRecords['frontend']->id,
                'question' => 'Trong JavaScript ES6, điểm khác nhau cơ bản giữa từ khóa "const" và "let" là gì?',
                'option_a' => 'const có phạm vi function, còn let có phạm vi global.',
                'option_b' => 'const không cho phép gán lại giá trị cho biến đã khai báo, trong khi let cho phép gán lại giá trị.',
                'option_c' => 'const chỉ dùng cho kiểu chuỗi string, let chỉ dùng cho số integer.',
                'option_d' => 'Cả hai hoàn toàn giống nhau không có điểm khác biệt.',
                'correct_option' => 'B',
                'explanation' => 'Biến khai báo bằng const là hằng số không thể gán lại giá trị (reassign), trong khi let cho phép gán lại giá trị mới trong block scope.',
                'difficulty' => 'easy',
                'points' => 10,
            ],

            // General / Company Culture questions (Giá trị AZ Media từ file bên trái)
            [
                'position_category' => 'general',
                'position_id' => null,
                'question' => 'Slogan chính thức của công ty AZ Media là gì?',
                'option_a' => 'Đổi mới sáng tạo - Vươn tầm quốc tế',
                'option_b' => 'Định hình tư duy – Chinh phục thị trường số',
                'option_c' => 'Chất lượng là danh dự - Vững bước tương lai',
                'option_d' => 'Giải pháp chuyển đổi số toàn diện cho doanh nghiệp',
                'correct_option' => 'B',
                'explanation' => 'Slogan chính thức của AZ Media là: "Định hình tư duy – Chinh phục thị trường số" (được quy định trong hồ sơ công ty và báo cáo thực tập).',
                'difficulty' => 'easy',
                'points' => 10,
            ],
            [
                'position_category' => 'general',
                'position_id' => null,
                'question' => 'Ý nghĩa chữ "A" trong tên thương hiệu AZ Media đại diện cho giá trị cốt lõi nào?',
                'option_a' => 'Action (Hành động): "Học lý thuyết để nắm rõ bản chất, hành động để thành công"',
                'option_b' => 'Advance (Tiến bộ): Không ngừng nâng cấp kỹ thuật mới',
                'option_c' => 'Ambition (Khát vọng): Trở thành tập đoàn số một miền Trung',
                'option_d' => 'Accuracy (Chính xác): Thực hiện các chỉ số đo lường chính xác',
                'correct_option' => 'A',
                'explanation' => 'Chữ A (Action) đại diện cho Hành động với tôn chỉ: "Học lý thuyết để nắm rõ bản chất, hành động để thành công".',
                'difficulty' => 'easy',
                'points' => 10,
            ],
            [
                'position_category' => 'general',
                'position_id' => null,
                'question' => 'Văn hóa môi trường làm việc tại AZ Media được xây dựng trên triết lý cốt lõi nào sau đây?',
                'option_a' => 'Làm việc 24/7 - Không ngừng nghỉ',
                'option_b' => 'Thầy giỏi - Bạn tốt - Sách hay',
                'option_c' => 'Cạnh tranh nội bộ - Đào thải liên tục',
                'option_d' => 'Tự do hoàn toàn - Không cần báo cáo',
                'correct_option' => 'B',
                'explanation' => 'Nhận thức được tầm quan trọng của 3 yếu tố quyết định sự phát triển của một con người, AZ Media xây dựng môi trường trên nền tảng "Thầy giỏi - Bạn tốt - Sách hay".',
                'difficulty' => 'easy',
                'points' => 10,
            ],
            // 4 câu hỏi Báo cáo thu hoạch NLB - DISC - MBTI - Nhân số học
            [
                'position_category' => 'general',
                'position_id' => null,
                'question' => 'Trong phương pháp đánh giá NLB, một người có phong cách tiếp nhận và xử lý công việc thiên về Visual (Hình ảnh / Thị giác) có đặc điểm nổi bật nào?',
                'option_a' => 'Dễ tiếp thu và xử lý công việc thông qua hình ảnh, mẫu thiết kế trực quan, ví dụ minh họa và quan sát thực tế.',
                'option_b' => 'Chỉ tiếp thu thông tin qua việc nghe giảng giải bằng lời nói và nhạy cảm với âm điệu.',
                'option_c' => 'Phải vận động thể chất liên tục mới có thể nắm bắt được yêu cầu của công việc.',
                'option_d' => 'Chỉ dựa vào cảm xúc nhất thời mà không cần quan sát hình ảnh hay dữ liệu thực tế.',
                'correct_option' => 'A',
                'explanation' => 'Phong cách Visual (Hình ảnh) giúp tiếp nhận thông tin tốt nhất qua thị giác, sơ đồ, giao diện và quan sát thực tế.',
                'difficulty' => 'easy',
                'points' => 10,
            ],
            [
                'position_category' => 'general',
                'position_id' => null,
                'question' => 'Theo mô hình trắc nghiệm DISC (cách làm việc), đặc điểm cốt lõi của người thiên về nhóm C (Cẩn trọng – Conscientiousness) là gì?',
                'option_a' => 'Thích ra quyết định nhanh, chấp nhận rủi ro cao và không quan tâm đến tiểu tiết.',
                'option_b' => 'Chú ý đến chi tiết, yêu cầu tính chính xác cao, chu đáo và luôn muốn hiểu rõ bản chất vấn đề trước khi thực hiện.',
                'option_c' => 'Thích giao lưu hướng ngoại, nói nhiều nhưng không bao giờ tuân thủ quy trình làm việc.',
                'option_d' => 'Thụ động, không có chính kiến và né tránh hoàn toàn trách nhiệm.',
                'correct_option' => 'B',
                'explanation' => 'Nhóm C (Cẩn trọng) có tư duy chi tiết, cẩn thận, yêu cầu độ chính xác cao và làm việc có quy chuẩn rõ ràng.',
                'difficulty' => 'medium',
                'points' => 10,
            ],
            [
                'position_category' => 'general',
                'position_id' => null,
                'question' => 'Trong trắc nghiệm tính cách MBTI, người có xu hướng Hướng nội (I - Introversion) kết hợp Cảm xúc (F - Feeling) thường thể hiện phẩm chất nào?',
                'option_a' => 'Tính cách trầm tĩnh, quan sát sâu sắc, coi trọng sự hài hòa và cân bằng giữa tính thực tế với khả năng sáng tạo.',
                'option_b' => 'Thích thể hiện bản thân trước đám đông và thường đưa ra quyết định độc đoán, lạnh lùng.',
                'option_c' => 'Bốc đồng, thay đổi liên tục và không thể gắn kết với các thành viên trong đội ngũ.',
                'option_d' => 'Không thích suy nghĩ sâu, chỉ làm việc theo thói quen máy móc.',
                'correct_option' => 'A',
                'explanation' => 'Người thuộc nhóm I-F có sự thấu cảm, coi trọng sự hòa thuận trong tập thể, biết lắng nghe và làm việc sâu sắc.',
                'difficulty' => 'medium',
                'points' => 10,
            ],
            [
                'position_category' => 'general',
                'position_id' => null,
                'question' => 'Dưới góc độ phát triển năng lực cá nhân và số học (con số đường đời số 9), giá trị cốt lõi nào giúp ứng viên gắn bó và cống hiến lâu dài tại AZ Media?',
                'option_a' => 'Chỉ mong muốn nhận hỗ trợ phụ cấp mà không quan tâm đến giá trị công việc mang lại.',
                'option_b' => 'Lòng trắc ẩn, tính bao dung, tinh thần trách nhiệm cao và mong muốn mang lại những giá trị tích cực cho cộng đồng.',
                'option_c' => 'Cạnh tranh gay gắt với đồng nghiệp để giành quyền lợi cá nhân.',
                'option_d' => 'Làm việc riêng lẻ, không hòa nhập văn hóa và từ chối học hỏi thêm công nghệ mới.',
                'correct_option' => 'B',
                'explanation' => 'Số đường đời 9 đại diện cho tinh thần trách nhiệm, lòng bao dung, trực giác tốt và sứ mệnh kiến tạo giá trị cho xã hội.',
                'difficulty' => 'easy',
                'points' => 10,
            ],
        ];

        foreach ($questions as $q) {
            TestQuestion::updateOrCreate(
                ['question' => $q['question']],
                $q
            );
        }

        // 5. Email Templates chuẩn quy trình (Workflow từ file bên phải)
        $templates = [
            [
                'code' => 'applied_received',
                'title' => 'Xác nhận tiếp nhận hồ sơ ứng tuyển',
                'subject' => '[AZ Media] Xác nhận tiếp nhận hồ sơ ứng tuyển - {candidate_name} - Mã HS: {application_code}',
                'body_html' => '<div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;padding:20px;border:1px solid #e2e8f0;border-radius:12px;background:#ffffff;">
                    <div style="text-align:center;padding-bottom:20px;border-bottom:2px solid #ea580c;">
                        <h2 style="color:#ea580c;margin:0;">CÔNG TY TNHH ĐẦU TƯ PHÁT TRIỂN DOANH NGHIỆP AZ HOMES</h2>
                        <h3 style="color:#1e293b;margin:5px 0 0 0;">CHI NHÁNH AZ MEDIA ĐÀ NẴNG</h3>
                        <p style="color:#64748b;font-size:13px;margin:4px 0 0 0;">Định hình tư duy – Chinh phục thị trường số</p>
                    </div>
                    <div style="padding:20px 0;">
                        <p>Kính gửi bạn <strong>{candidate_name}</strong>,</p>
                        <p>Bộ phận Tuyển dụng AZ Media xin chân thành cảm ơn bạn đã quan tâm và nộp hồ sơ ứng tuyển vị trí: <span style="color:#ea580c;font-weight:bold;">{position_title}</span>.</p>
                        <div style="background:#fff7ed;padding:15px;border-left:4px solid #ea580c;border-radius:6px;margin:15px 0;">
                            <p style="margin:0;font-size:14px;color:#9a3412;"><strong>MÃ TRA CỨU HỒ SƠ:</strong> <span style="font-size:18px;letter-spacing:1px;font-weight:bold;color:#c2410c;">{application_code}</span></p>
                            <p style="margin:5px 0 0 0;font-size:13px;color:#64748b;">Bạn có thể dùng mã này hoặc email để tra cứu tiến độ ứng tuyển trực tuyến tại Candidate Portal bất kỳ lúc nào.</p>
                        </div>
                        <p>Quy trình sàng lọc hồ sơ sẽ diễn ra trong vòng 2 - 3 ngày làm việc. Nếu hồ sơ phù hợp, chúng tôi sẽ gửi đường dẫn bài kiểm tra chuyên môn (Online Test) và lịch phỏng vấn tiếp theo.</p>
                        <p>Chúc bạn có một kỳ thực tập bổ ích và phát triển vượt bậc cùng AZ Media!</p>
                    </div>
                    <div style="border-top:1px solid #e2e8f0;padding-top:15px;font-size:12px;color:#64748b;line-height:1.6;">
                        <p style="margin:0;"><strong>Văn phòng Chi nhánh Đà Nẵng:</strong> 84 Nguyễn Hữu Dật, P. Hòa Cường, TP. Đà Nẵng</p>
                        <p style="margin:0;"><strong>Hotline tuyển dụng:</strong> 0968825068 | <strong>Email:</strong> hr@azmedia.com.vn</p>
                        <p style="margin:0;"><strong>Website:</strong> https://azmedia.com.vn</p>
                    </div>
                </div>',
            ],
            [
                'code' => 'test_invitation',
                'title' => 'Thư mời làm bài kiểm tra năng lực trực tuyến',
                'subject' => '[AZHR] 📝 Thông báo Duyệt CV & Thư mời làm bài Test Online - {candidate_name}',
                'body_html' => '<div style="font-family: \'Segoe UI\', Arial, sans-serif; color: #1e293b; line-height: 1.7; max-width: 600px; margin: auto; padding: 22px; border: 1px solid #e2e8f0; border-radius: 16px; background: #ffffff;">
                    <div style="text-align: center; padding-bottom: 16px; border-bottom: 2px solid #ea580c;">
                        <h2 style="color: #ea580c; margin: 0; font-size: 20px;">CHI NHÁNH AZ MEDIA ĐÀ NẴNG</h2>
                        <h3 style="color: #1e293b; margin: 4px 0 0 0; font-size: 15px;">THÔNG BÁO DUYỆT HỒ SƠ & MỜI LÀM BÀI TEST ONLINE</h3>
                    </div>

                    <div style="padding: 20px 0;">
                        <p style="font-size: 15px; margin-bottom: 12px;">Xin chào <strong style="color: #ea580c;">{candidate_name}</strong>,</p>

                        <p style="margin-bottom: 14px;">
                            Chúc mừng bạn! Hồ sơ ứng tuyển vị trí <strong>{position_title}</strong> của bạn đã được hệ thống <strong>TỰ ĐỘNG XÉT DUYỆT CV THÀNH CÔNG</strong>.
                        </p>

                        <div style="background: #fff7ed; border-left: 4px solid #ea580c; border-radius: 8px; padding: 14px 18px; margin: 16px 0;">
                            <p style="margin: 0; font-size: 13px; color: #9a3412;"><strong>MÃ TRA CỨU HỒ SƠ:</strong> <span style="font-size: 17px; font-weight: 800; color: #c2410c; letter-spacing: 1px;">{application_code}</span></p>
                            <p style="margin: 5px 0 0 0; font-size: 12px; color: #64748b;">Bạn có thể tra cứu tiến trình tại: <a href="{track_url}" style="color: #ea580c; font-weight: bold;">Tra cứu tiến độ hồ sơ</a></p>
                        </div>

                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 18px; margin: 18px 0;">
                            <div style="font-weight: 700; color: #1e40af; font-size: 14px; margin-bottom: 8px;">📝 THÔNG TIN BÀI ĐÁNH GIÁ NĂNG LỰC TOÀN DIỆN:</div>
                            <ul style="margin: 0; padding-left: 18px; line-height: 1.9; font-size: 13px; color: #1e3a8a;">
                                <li><strong>Phần 1:</strong> Trắc nghiệm nhận diện tính cách NLP (V-A-K-Ad)</li>
                                <li><strong>Phần 2:</strong> Đánh giá cân bằng cuộc sống "Wheel of Life" (Bánh xe cuộc đời)</li>
                                <li><strong>Phần 3:</strong> Khảo sát hoài bão, động cơ & kế hoạch phát triển cá nhân</li>
                                <li><strong>Phần 4:</strong> Trắc nghiệm kiến thức chuyên môn & văn hóa doanh nghiệp</li>
                                <li><strong>Thời gian:</strong> Tự do, không giới hạn thời gian làm bài</li>
                            </ul>
                        </div>

                        <div style="text-align: center; margin: 24px 0;">
                            <a href="{test_link}" style="background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); color: #ffffff; padding: 14px 36px; border-radius: 12px; text-decoration: none; font-weight: 800; font-size: 15px; display: inline-block; box-shadow: 0 4px 14px rgba(234,88,12,0.35);">
                                🚀 BẮT ĐẦU LÀM BÀI TEST NGAY
                            </a>
                        </div>

                        <!-- Khối tham gia nhóm Zalo Ứng tuyển -->
                        <div style="background: #f0fdf4; border: 2px solid #86efac; border-radius: 14px; padding: 18px 20px; margin: 24px 0;">
                            <div style="font-weight: 800; color: #15803d; font-size: 15px; margin-bottom: 8px;">
                                💬 THAM GIA NHÓM ZALO: NHÓM AZ HR - ỨNG TUYỂN
                            </div>
                            <p style="margin: 0 0 12px 0; font-size: 13px; color: #166534; line-height: 1.6;">
                                Mời bạn tham gia nhóm Zalo tuyển dụng để <strong>tham khảo tài liệu hướng dẫn làm bài test, được giải đáp thắc mắc trực tiếp từ Mentor</strong> và <strong>nhận các thông báo tuyển dụng / lịch phỏng vấn nhanh nhất</strong>:
                            </p>
                            <div style="text-align: center; margin: 14px 0;">
                                <a href="https://zalo.me/g/fcypks402" target="_blank" style="display: inline-block; background: #0068ff; color: #ffffff; padding: 12px 28px; text-decoration: none; border-radius: 10px; font-weight: 800; font-size: 14px; box-shadow: 0 4px 12px rgba(0,104,255,0.3);">
                                    📲 THAM GIA NHÓM ZALO ỨNG TUYỂN (BẤM VÀO ĐÂY)
                                </a>
                            </div>
                            <p style="margin: 6px 0 0 0; font-size: 12px; color: #15803d; text-align: center;">
                                Đường dẫn tham gia: <a href="https://zalo.me/g/fcypks402" style="color: #0068ff; font-weight: 700;">https://zalo.me/g/fcypks402</a>
                            </p>
                        </div>

                        <p style="font-size: 12px; color: #64748b; font-style: italic; text-align: center;">
                            * Đường link làm bài test cá nhân hóa: <a href="{test_link}" style="color: #ea580c;">{test_link}</a>
                        </p>
                    </div>

                    <div style="border-top: 1px solid #e2e8f0; padding-top: 15px; font-size: 12px; color: #64748b; line-height: 1.6;">
                        <p style="margin: 0;"><strong>Ban Tuyển Dụng & Đào Tạo AZHR - AZ Media Đà Nẵng</strong></p>
                        <p style="margin: 0;">Địa chỉ: 84 Nguyễn Hữu Dật, P. Hòa Cường, Q. Hải Châu, TP. Đà Nẵng | Hotline: 0968.825.068</p>
                    </div>
                </div>',
            ],
            [
                'code' => 'interview_invitation',
                'title' => 'Thư mời phỏng vấn trực tiếp / Online',
                'subject' => '[AZ Media] Thư mời tham gia Phỏng vấn Thực tập sinh - {candidate_name}',
                'body_html' => '<div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;padding:20px;border:1px solid #e2e8f0;border-radius:12px;background:#ffffff;">
                    <div style="text-align:center;padding-bottom:20px;border-bottom:2px solid #ea580c;">
                        <h2 style="color:#ea580c;margin:0;">CHI NHÁNH AZ MEDIA ĐÀ NẴNG</h2>
                        <h3 style="color:#1e293b;margin:5px 0 0 0;">THƯ MỜI PHỎNG VẤN THỰC TẬP SINH</h3>
                    </div>
                    <div style="padding:20px 0;">
                        <p>Chào bạn <strong>{candidate_name}</strong>,</p>
                        <p>Chúc mừng bạn đã hoàn thành xuất sắc vòng kiểm tra năng lực! Ban chuyên môn và bộ phận HR AZ Media trân trọng mời bạn tham dự buổi phỏng vấn trao đổi chi tiết về lộ trình thực tập.</p>
                        <div style="background:#f8fafc;padding:18px;border:1px solid #cbd5e1;border-radius:8px;margin:20px 0;">
                            <p style="margin:6px 0;">📅 <strong>Thời gian:</strong> <span style="color:#ea580c;font-weight:bold;">{interview_time}</span></p>
                            <p style="margin:6px 0;">📍 <strong>Hình thức / Địa điểm:</strong> {interview_location}</p>
                            <p style="margin:6px 0;">💻 <strong>Đường dẫn Online (nếu có):</strong> <a href="{interview_link}" style="color:#2563eb;word-break:break-all;">{interview_link}</a></p>
                            <p style="margin:6px 0;">👨‍🏫 <strong>Người phỏng vấn (Interviewer):</strong> Lê Đình Quang & Ban Tuyển dụng HR</p>
                        </div>
                        <p>Vui lòng phản hồi email này để xác nhận sự có mặt của bạn trước 24 giờ. Rất mong được gặp bạn!</p>
                    </div>
                    <div style="border-top:1px solid #e2e8f0;padding-top:15px;font-size:12px;color:#64748b;">
                        <p style="margin:0;">AZ Media - 84 Nguyễn Hữu Dật, P. Hòa Cường, Q. Hải Châu, TP. Đà Nẵng | Hotline: 0968825068</p>
                    </div>
                </div>',
            ],
            [
                'code' => 'offer_congrats',
                'title' => 'Thư chúc mừng trúng tuyển thực tập (Offer Letter)',
                'subject' => '[AZ Media] Chúc mừng bạn trúng tuyển kỳ Thực tập sinh - {candidate_name}',
                'body_html' => '<div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;padding:20px;border:1px solid #e2e8f0;border-radius:12px;background:#ffffff;">
                    <div style="text-align:center;padding-bottom:20px;border-bottom:2px solid #16a34a;">
                        <h2 style="color:#16a34a;margin:0;">CHÚC MỪNG GIA NHẬP AZ MEDIA! 🎉</h2>
                        <h3 style="color:#1e293b;margin:5px 0 0 0;">THƯ MỜI TIẾP NHẬN THỰC TẬP SINH CHÍNH THỨC</h3>
                    </div>
                    <div style="padding:20px 0;">
                        <p>Thân gửi bạn <strong>{candidate_name}</strong>,</p>
                        <p>Sau các vòng đánh giá chuyên môn và phỏng vấn, Hội đồng Đánh giá AZ Media rất ấn tượng với thái độ, tư duy và năng lực của bạn. Chúng tôi trân trọng gửi lời mời bạn chính thức gia nhập chương trình Thực tập sinh tài năng tại AZ Media!</p>
                        <div style="background:#f0fdf4;padding:18px;border-left:4px solid #16a34a;border-radius:8px;margin:20px 0;">
                            <p style="margin:6px 0;">🎯 <strong>Vị trí tiếp nhận:</strong> <span style="font-weight:bold;color:#15803d;">{position_title}</span></p>
                            <p style="margin:6px 0;">🏢 <strong>Địa điểm làm việc:</strong> 84 Nguyễn Hữu Dật, P. Hòa Cường, Q. Hải Châu, TP. Đà Nẵng</p>
                            <p style="margin:6px 0;">💰 <strong>Mức hỗ trợ phụ cấp:</strong> Theo chính sách và cam kết đánh giá định kỳ</p>
                            <p style="margin:6px 0;">👨‍🏫 <strong>Mentor đồng hành:</strong> Lê Đình Quang & Đội ngũ Kỹ thuật</p>
                            <p style="margin:6px 0;">📜 <strong>Quyền lợi:</strong> Đóng dấu mộc tròn doanh nghiệp xác nhận báo cáo thực tập, đào tạo 1-1, cơ hội trở thành nhân viên chính thức.</p>
                        </div>
                        <p>Chào mừng bạn đến với môi trường <em>"Thầy giỏi - Bạn tốt - Sách hay"</em> và cùng chúng tôi chinh phục mục tiêu từ &quot;nhỏ bé thành khổng lồ&quot;!</p>
                    </div>
                    <div style="border-top:1px solid #e2e8f0;padding-top:15px;font-size:12px;color:#64748b;">
                        <p style="margin:0;">Tổng Giám Đốc: Lê Đình Quang | Chi nhánh AZ Media Đà Nẵng</p>
                    </div>
                </div>',
            ],
            [
                'code' => 'thank_you_rejection',
                'title' => 'Thư cảm ơn và lưu trữ hồ sơ',
                'subject' => '[AZ Media] Thư cảm ơn bạn đã quan tâm ứng tuyển - {candidate_name}',
                'body_html' => '<div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;padding:20px;border:1px solid #e2e8f0;border-radius:12px;background:#ffffff;">
                    <div style="text-align:center;padding-bottom:20px;border-bottom:2px solid #64748b;">
                        <h2 style="color:#ea580c;margin:0;">CHI NHÁNH AZ MEDIA ĐÀ NẴNG</h2>
                        <h3 style="color:#1e293b;margin:5px 0 0 0;">THƯ CẢM ƠN ỨNG VIÊN</h3>
                    </div>
                    <div style="padding:20px 0;">
                        <p>Thân gửi bạn <strong>{candidate_name}</strong>,</p>
                        <p>Bộ phận Tuyển dụng AZ Media xin chân thành cảm ơn bạn đã dành thời gian tham gia ứng tuyển và phỏng vấn vị trí: <strong>{position_title}</strong>.</p>
                        <p>Mặc dù nhận thấy bạn có tinh thần nhiệt huyết và tiềm năng tốt, tuy nhiên ở đợt tiếp nhận thực tập sinh lần này, chúng tôi cần ưu tiên những ứng viên có sự tương thích cao hơn với mục tiêu dự án hiện tại.</p>
                        <p>Chúng tôi đã lưu lại thông tin hồ sơ của bạn trong cơ sở dữ liệu Talent Pool của AZ Media và sẽ chủ động liên hệ khi có cơ hội hoặc dự án mới phù hợp hơn.</p>
                        <p>Chúc bạn luôn giữ vững niềm đam mê và gặt hái nhiều thành công rực rỡ trên con đường sự nghiệp!</p>
                    </div>
                    <div style="border-top:1px solid #e2e8f0;padding-top:15px;font-size:12px;color:#64748b;">
                        <p style="margin:0;">Trân trọng,<br>Bộ phận Nhân sự & Tuyển dụng AZ Media Đà Nẵng</p>
                    </div>
                </div>',
            ],
        ];

        foreach ($templates as $t) {
            EmailTemplate::updateOrCreate(['code' => $t['code']], $t);
        }

        // 6. Seed Candidates & Applications thực tế (Đặc biệt có sinh viên Nguyễn Nhật Linh Ân từ file bên trái!)
        $candidatesData = [
            [
                'name' => 'Nguyễn Nhật Linh Ân',
                'email' => 'linhan.nguyen@azmedia.com.vn',
                'phone' => '0968825068',
                'university' => 'Cao đẳng Đà Nẵng (DNC)',
                'major' => 'Công nghệ Thông tin (24CNTT1A)',
                'academic_year' => 'Năm 2',
                'gpa' => 3.85,
                'github_url' => 'https://github.com/nhatlinhan',
                'portfolio_url' => 'https://portfolio.azmedia.com.vn/linhan',
                'working_shift' => 'fulltime',
                'address' => 'Hòa Cường, Hải Châu, Đà Nẵng',
                // Application details
                'app_code' => 'AZ-2026-0732', // Mã ứng viên gắn liền với MSSV 24C0732!
                'position_key' => 'backend',
                'status' => 'offered',
                'stage_step' => 5,
                'cover_letter' => 'Em là sinh viên lớp 24CNTT1A khoa CNTT trường Cao đẳng Đà Nẵng. Em mong muốn được thực tập tại AZ Media chi nhánh Đà Nẵng theo hướng dẫn của thầy Đặng Quý Linh để nghiên cứu và xây dựng hệ thống website tuyển dụng thực tập sinh, nắm vững bản chất kiến trúc MVC/Laravel và biến lý thuyết thành hành động theo đúng triết lý A-Z-M của công ty.',
                'cv_filename' => 'CV_Nguyen_Nhat_Linh_An_24CNTT1A.pdf',
                'cv_path' => 'uploads/cvs/CV_Nguyen_Nhat_Linh_An_24CNTT1A.pdf',
                'interview_time' => '2026-10-10 09:30:00',
                'interview_type' => 'offline',
                'interview_location' => 'Văn phòng AZ Media - 84 Nguyễn Hữu Dật, P. Hòa Cường, Q. Hải Châu, TP. Đà Nẵng',
                'interview_link' => 'https://meet.google.com/azm-dnc-tech',
                'test_score' => 95.0,
                'eval_scores' => [
                    'tech' => 9.5,
                    'logic' => 9.0,
                    'attitude' => 10.0,
                    'comm' => 9.0,
                    'rec' => 'pass',
                    'comment' => 'Sinh viên nắm rất vững kiến thức lập trình Web nâng cao, thành thạo Laravel, CSDL MySQL và tinh thần học hỏi rất cao. Đạt 100% tiêu chí văn hóa "Thầy giỏi - Bạn tốt - Sách hay". Đề xuất tiếp nhận thực tập và cấp học bổng hỗ trợ dự án.'
                ]
            ],
            [
                'name' => 'Trần Văn Hoàng',
                'email' => 'hoang.tran@gmail.com',
                'phone' => '0912345678',
                'university' => 'Đại học Bách Khoa - ĐH Đà Nẵng',
                'major' => 'Kỹ thuật Phần mềm',
                'academic_year' => 'Năm 3',
                'gpa' => 3.45,
                'github_url' => 'https://github.com/hoangtran-dev',
                'portfolio_url' => 'https://hoangtran.dev',
                'working_shift' => 'morning',
                'address' => 'Liên Chiểu, Đà Nẵng',
                'app_code' => 'AZ-2026-1021',
                'position_key' => 'frontend',
                'status' => 'interviewing',
                'stage_step' => 4,
                'cover_letter' => 'Em có kinh nghiệm làm việc với React và Tailwind CSS, mong muốn ứng tuyển vị trí Thực tập sinh Frontend để phát triển sản phẩm SPA cho AZ Media.',
                'cv_filename' => 'CV_Tran_Van_Hoang_DUT.pdf',
                'cv_path' => 'uploads/cvs/CV_Tran_Van_Hoang_DUT.pdf',
                'interview_time' => '2026-10-15 14:00:00',
                'interview_type' => 'online',
                'interview_location' => 'Phỏng vấn Online qua Google Meet',
                'interview_link' => 'https://meet.google.com/azm-interview-dut',
                'test_score' => 85.0,
                'eval_scores' => [
                    'tech' => 8.5,
                    'logic' => 8.0,
                    'attitude' => 9.0,
                    'comm' => 8.5,
                    'rec' => 'consider',
                    'comment' => 'Kỹ năng Frontend tốt, responsive sạch sẽ, đang chờ phỏng vấn trực tiếp vòng 2.'
                ]
            ],
            [
                'name' => 'Lê Thị Phương Thảo',
                'email' => 'thaole.design@gmail.com',
                'phone' => '0935123456',
                'university' => 'ĐH CNTT & Truyền thông Việt - Hàn (VKU)',
                'major' => 'Truyền thông Đa phương tiện',
                'academic_year' => 'Năm 4',
                'gpa' => 3.60,
                'github_url' => null,
                'portfolio_url' => 'https://behance.net/thaole_uiux',
                'working_shift' => 'flexible',
                'address' => 'Ngũ Hành Sơn, Đà Nẵng',
                'app_code' => 'AZ-2026-2045',
                'position_key' => 'uiux',
                'status' => 'tested',
                'stage_step' => 3,
                'cover_letter' => 'Em đam mê thiết kế giao diện Figma và nghiên cứu Design System. Em muốn đồng hành xây dựng giao diện tươi trẻ cho AZ Media.',
                'cv_filename' => 'CV_Le_Thi_Phuong_Thao_VKU.pdf',
                'cv_path' => 'uploads/cvs/CV_Le_Thi_Phuong_Thao_VKU.pdf',
                'interview_time' => null,
                'interview_type' => null,
                'interview_location' => null,
                'interview_link' => null,
                'test_score' => 80.0,
                'eval_scores' => null
            ],
            [
                'name' => 'Phạm Minh Tuấn',
                'email' => 'tuan.pham@gmail.com',
                'phone' => '0988776655',
                'university' => 'Đại học Duy Tân (DTU)',
                'major' => 'Công nghệ Phần mềm',
                'academic_year' => 'Năm 3',
                'gpa' => 3.20,
                'github_url' => 'https://github.com/tuanpham-qa',
                'portfolio_url' => null,
                'working_shift' => 'afternoon',
                'address' => 'Thanh Khê, Đà Nẵng',
                'app_code' => 'AZ-2026-3088',
                'position_key' => 'tester',
                'status' => 'test_sent',
                'stage_step' => 2,
                'cover_letter' => 'Em muốn thực tập vị trí QA Tester để trau dồi kỹ năng viết Test Case và bảo đảm chất lượng sản phẩm.',
                'cv_filename' => 'CV_Pham_Minh_Tuan_DTU.pdf',
                'cv_path' => 'uploads/cvs/CV_Pham_Minh_Tuan_DTU.pdf',
                'interview_time' => null,
                'interview_type' => null,
                'interview_location' => null,
                'interview_link' => null,
                'test_score' => null,
                'eval_scores' => null
            ],
            [
                'name' => 'Đỗ Hoàng Nam',
                'email' => 'nam.do@gmail.com',
                'phone' => '0905112233',
                'university' => 'ĐH Sư phạm Kỹ thuật - ĐH Đà Nẵng',
                'major' => 'Công nghệ Thông tin',
                'academic_year' => 'Năm 2',
                'gpa' => 2.90,
                'github_url' => 'https://github.com/namdo',
                'portfolio_url' => null,
                'working_shift' => 'morning',
                'address' => 'Cẩm Lệ, Đà Nẵng',
                'app_code' => 'AZ-2026-4112',
                'position_key' => 'backend',
                'status' => 'applied',
                'stage_step' => 1,
                'cover_letter' => 'Em mới hoàn thành môn lập trình web và muốn nộp đơn học hỏi tại AZ Media.',
                'cv_filename' => 'CV_Do_Hoang_Nam_UTE.pdf',
                'cv_path' => 'uploads/cvs/CV_Do_Hoang_Nam_UTE.pdf',
                'interview_time' => null,
                'interview_type' => null,
                'interview_location' => null,
                'interview_link' => null,
                'test_score' => null,
                'eval_scores' => null
            ],
            [
                'name' => 'Ngô Bảo Trâm',
                'email' => 'tram.ngo@gmail.com',
                'phone' => '0977443322',
                'university' => 'Đại học FPT Đà Nẵng',
                'major' => 'Digital Marketing',
                'academic_year' => 'Năm 3',
                'gpa' => 3.50,
                'github_url' => null,
                'portfolio_url' => 'https://tiktok.com/@tramngo_mkt',
                'working_shift' => 'flexible',
                'address' => 'Sơn Trà, Đà Nẵng',
                'app_code' => 'AZ-2026-5220',
                'position_key' => 'marketing',
                'status' => 'offered',
                'stage_step' => 5,
                'cover_letter' => 'Em có kinh nghiệm sáng tạo nội dung video TikTok ngắn và mong muốn lan tỏa hình ảnh AZ Media với Slogan "Định hình tư duy – Chinh phục thị trường số".',
                'cv_filename' => 'CV_Ngo_Bao_Tram_FPT.pdf',
                'cv_path' => 'uploads/cvs/CV_Ngo_Bao_Tram_FPT.pdf',
                'interview_time' => '2026-10-08 10:00:00',
                'interview_type' => 'offline',
                'interview_location' => '84 Nguyễn Hữu Dật, Hải Châu, Đà Nẵng',
                'interview_link' => null,
                'test_score' => 90.0,
                'eval_scores' => [
                    'tech' => 9.0,
                    'logic' => 9.0,
                    'attitude' => 9.5,
                    'comm' => 10.0,
                    'rec' => 'pass',
                    'comment' => 'Năng động, có khả năng tư duy truyền thông nhạy bén, rất phù hợp phát triển các kênh TikTok và Threads của AZ Media.'
                ]
            ],
            [
                'name' => 'Hoàng Khắc Huy',
                'email' => 'huy.hoang@gmail.com',
                'phone' => '0944889900',
                'university' => 'Đại học Kinh tế - ĐH Đà Nẵng',
                'major' => 'Thương mại Điện tử',
                'academic_year' => 'Năm 4',
                'gpa' => 2.50,
                'github_url' => null,
                'portfolio_url' => null,
                'working_shift' => 'flexible',
                'address' => 'Ngũ Hành Sơn, Đà Nẵng',
                'app_code' => 'AZ-2026-6331',
                'position_key' => 'marketing',
                'status' => 'rejected',
                'stage_step' => 0,
                'cover_letter' => 'Em muốn xin thực tập lấy dấu mộc trường.',
                'cv_filename' => 'CV_Hoang_Khac_Huy.pdf',
                'cv_path' => 'uploads/cvs/CV_Hoang_Khac_Huy.pdf',
                'interview_time' => null,
                'interview_type' => null,
                'interview_location' => null,
                'interview_link' => null,
                'test_score' => 45.0,
                'eval_scores' => [
                    'tech' => 4.0,
                    'logic' => 4.5,
                    'attitude' => 5.0,
                    'comm' => 5.0,
                    'rec' => 'fail',
                    'comment' => 'Mục tiêu thực tập chưa rõ ràng, chưa thể hiện được sự cam kết với văn hóa công ty. Đã gửi thư cảm ơn và lưu trữ hồ sơ.'
                ]
            ],
        ];

        foreach ($candidatesData as $cData) {
            $candidate = Candidate::updateOrCreate(
                ['email' => $cData['email']],
                [
                    'name' => $cData['name'],
                    'phone' => $cData['phone'],
                    'university' => $cData['university'],
                    'major' => $cData['major'],
                    'academic_year' => $cData['academic_year'],
                    'gpa' => $cData['gpa'],
                    'github_url' => $cData['github_url'],
                    'portfolio_url' => $cData['portfolio_url'],
                    'working_shift' => $cData['working_shift'],
                    'address' => $cData['address'],
                ]
            );

            $pos = $posRecords[$cData['position_key']] ?? $posRecords['backend'];

            $app = Application::updateOrCreate(
                ['application_code' => $cData['app_code']],
                [
                    'candidate_id' => $candidate->id,
                    'position_id' => $pos->id,
                    'cv_path' => $cData['cv_path'],
                    'cv_filename' => $cData['cv_filename'],
                    'cover_letter' => $cData['cover_letter'],
                    'status' => $cData['status'],
                    'stage_step' => $cData['stage_step'],
                    'interview_time' => $cData['interview_time'],
                    'interview_type' => $cData['interview_type'],
                    'interview_location' => $cData['interview_location'],
                    'interview_link' => $cData['interview_link'],
                    'assigned_mentor_id' => $mentorUser ? $mentorUser->id : null,
                ]
            );

            // Test result nếu có
            if ($cData['test_score'] !== null) {
                CandidateTest::updateOrCreate(
                    ['application_id' => $app->id],
                    [
                        'total_questions' => 10,
                        'correct_answers' => round($cData['test_score'] / 10),
                        'score' => $cData['test_score'],
                        'time_spent_seconds' => rand(600, 1100),
                        'passed' => ($cData['test_score'] >= 70),
                        'completed_at' => now()->subDays(rand(1, 5)),
                    ]
                );
            }

            // Evaluation scorecard nếu có
            if (!empty($cData['eval_scores'])) {
                $ev = $cData['eval_scores'];
                $avg = ($ev['tech'] + $ev['logic'] + $ev['attitude'] + $ev['comm']) / 4;
                Evaluation::updateOrCreate(
                    ['application_id' => $app->id, 'evaluator_id' => $mentorUser ? $mentorUser->id : 1],
                    [
                        'evaluator_name' => 'Lê Đình Quang',
                        'evaluator_role' => 'mentor',
                        'technical_score' => $ev['tech'],
                        'logic_score' => $ev['logic'],
                        'attitude_score' => $ev['attitude'],
                        'communication_score' => $ev['comm'],
                        'average_score' => $avg,
                        'strengths' => 'Nắm chắc kiến thức nền tảng, có tư duy logic tốt, nhiệt tình và trách nhiệm.',
                        'weaknesses' => 'Cần tích lũy thêm kinh nghiệm làm việc thực tế với hệ thống lớn.',
                        'general_comment' => $ev['comment'],
                        'recommendation' => $ev['rec'],
                    ]
                );
            }

            // Email Log mẫu
            EmailLog::create([
                'application_id' => $app->id,
                'recipient_email' => $candidate->email,
                'recipient_name' => $candidate->name,
                'template_code' => 'applied_received',
                'subject' => "[AZ Media] Xác nhận tiếp nhận hồ sơ - {$candidate->name} - {$app->application_code}",
                'body_preview' => "Hồ sơ ứng tuyển vị trí {$pos->title} đã được tiếp nhận thành công vào hệ thống AZ Media.",
                'status' => 'sent',
                'sent_at' => now()->subDays(rand(2, 6)),
            ]);
        }
    }
}
