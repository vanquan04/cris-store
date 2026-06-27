<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Config;

class SoccerProductsSeeder extends Seeder
{
    public function run()
    {
        // 1. Rename existing configs to represent shoe sizes from 35 to 44
        // The existing config IDs are 4, 5, 6. We will rename them to 38, 39, 40.
        // We will also insert other configs to cover the range from 35 to 44.
        $sizesToSeed = [
            35 => 'Size 35',
            36 => 'Size 36',
            37 => 'Size 37',
            38 => 'Size 38',
            39 => 'Size 39',
            40 => 'Size 40',
            41 => 'Size 41',
            42 => 'Size 42',
            43 => 'Size 43',
            44 => 'Size 44',
        ];

        // Ensure we have correct sizes in configs table
        // We map existing config IDs: 4 -> size 38, 5 -> size 39, 6 -> size 40
        Config::updateOrCreate(['id' => 4], ['name' => 'Size 38', 'memory' => '38', 'status' => 1, 'creator' => 22]);
        Config::updateOrCreate(['id' => 5], ['name' => 'Size 39', 'memory' => '39', 'status' => 1, 'creator' => 22]);
        Config::updateOrCreate(['id' => 6], ['name' => 'Size 40', 'memory' => '40', 'status' => 1, 'creator' => 22]);

        // Insert/update remaining sizes with specific IDs matching the size number (or dynamic)
        foreach ($sizesToSeed as $sizeNum => $sizeName) {
            if (in_array($sizeNum, [38, 39, 40])) {
                continue; // already updated above
            }
            Config::updateOrCreate(
                ['id' => $sizeNum],
                ['name' => $sizeName, 'memory' => (string)$sizeNum, 'status' => 1, 'creator' => 22]
            );
        }

        // 2. Define beautiful soccer products data
        $soccerProducts = [
            75 => [
                'name' => 'Giày Bóng Đá Nike Mercurial Vapor 15 Academy TF',
                'code' => 'TQ#75',
                'slug' => 'giay-bong-da-nike-mercurial-vapor-15-academy-tf',
                'cat_id' => 70, // Giày Nike Mercurial
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#75</li><li>Thương hiệu: Nike</li><li>Loại đế: TF (Sân cỏ nhân tạo)</li><li>Phân khúc: Academy (Bán chuyên)</li><li>Chất liệu: Da tổng hợp cao cấp phủ lớp hạt Nikeskin hỗ trợ kiểm soát bóng</li><li>Size giày: 35 - 44 (Đầy đủ kích cỡ)</li></ul>',
                'desc_detail' => '<p>Giày bóng đá Nike Mercurial Vapor 15 Academy TF là sự lựa chọn hàng đầu cho các cầu thủ ưa thích lối chơi tốc độ và lắt léo trên mặt sân cỏ nhân tạo. Với thiết kế hiện đại, trọng lượng siêu nhẹ kết hợp cùng bộ đệm Zoom Air êm ái dưới gót chân, đôi giày mang lại cảm giác bứt tốc cực tốt và sự thoải mái tối đa suốt cả trận đấu.</p><p><strong>Đặc điểm nổi bật:</strong></p><p>- Upper làm từ chất liệu NikeSkin mềm mại, có các họa tiết nổi giúp tăng cường cảm giác bóng và kiểm soát bóng chính xác ở tốc độ cao.</p><p>- Bộ đệm Zoom Air lần đầu tiên được tích hợp ở phần đế ngoài, mang lại khả năng phản hồi lực cực tốt.</p><p>- Đế ngoài bằng cao su bền bỉ với hệ thống đinh dăm TF bám sân vượt trội, chống trơn trượt hiệu quả.</p>',
                'old_price' => 2100000,
                'new_price' => 1850000,
                'sizes' => [37, 38, 39, 40, 41, 42, 43],
            ],
            76 => [
                'name' => 'Áo Đấu Real Madrid Sân Nhà 2024/2025',
                'code' => 'TQ#76',
                'slug' => 'ao-dau-real-madrid-san-nha-2024-2025',
                'cat_id' => 58, // Áo Real Madrid
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#76</li><li>Thương hiệu: Adidas</li><li>Loại sản phẩm: Áo đấu bóng đá</li><li>Mùa giải: 2024/2025</li><li>Chất liệu: 100% Polyester tái chế với công nghệ HEAT.RDY</li><li>Size áo: S, M, L, XL, XXL</li></ul>',
                'desc_detail' => '<p>Mẫu áo đấu Real Madrid sân nhà mùa giải 2024/2025 mang phong cách hoàng gia đặc trưng với tông màu trắng chủ đạo kết hợp các họa tiết chìm sang trọng tinh tế. Biểu tượng câu lạc bộ được dệt sắc nét trên ngực trái tạo niềm kiêu hãnh cho các Madridista.</p><p><strong>Tính năng vượt trội:</strong></p><p>- Chất liệu thun lạnh cao cấp, co giãn 4 chiều tốt, siêu thấm hút mồ hôi và cực kỳ thoáng mát.</p><p>- Công nghệ kháng khuẩn, không phai màu, không xù lông khi giặt máy.</p><p>- Form dáng thể thao ôm nhẹ, tôn dáng người mặc phù hợp cả thi đấu lẫn thời trang thường ngày.</p>',
                'old_price' => 350000,
                'new_price' => 220000,
                'sizes' => [38, 39, 40], // mapped to S, M, L for simplicity
            ],
            77 => [
                'name' => 'Áo Đấu Barcelona Sân Khách 24/25',
                'code' => 'TQ#77',
                'slug' => 'ao-dau-barcelona-san-khach-24-25',
                'cat_id' => 59, // Áo Barcelona
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#77</li><li>Thương hiệu: Nike</li><li>Loại sản phẩm: Áo đấu bóng đá</li><li>Mùa giải: 2024/2025</li><li>Chất liệu: Vải Dri-FIT kháng khuẩn, siêu nhẹ và thông thoáng</li><li>Size áo: S, M, L, XL</li></ul>',
                'desc_detail' => '<p>Mẫu áo đấu Barcelona sân khách 2024/2025 sở hữu thiết kế độc đáo với phối màu đen lịch lãm kết hợp các viền màu Blaugrana đỏ xanh truyền thống đầy cuốn hút ở cổ áo và bo tay. Đây là món đồ không thể thiếu đối với những người yêu mến gã khổng lồ xứ Catalan.</p><p><strong>Chi tiết sản phẩm:</strong></p><p>- Công nghệ Nike Dri-FIT tiên tiến giúp đẩy mồ hôi ra xa cơ thể giúp bạn luôn khô ráo và thoải mái.</p><p>- Logo CLB và logo Nike được thêu công nghệ 3D sắc sảo nổi bật trên ngực áo.</p><p>- Chất vải mềm mịn, an toàn tuyệt đối cho da nhạy cảm khi vận động cường độ cao.</p>',
                'old_price' => 350000,
                'new_price' => 230000,
                'sizes' => [38, 39, 40],
            ],
            78 => [
                'name' => 'Quả Bóng Đá Ngoại Hạng Anh Nike Flight',
                'code' => 'TQ#78',
                'slug' => 'qua-bong-da-ngoai-hang-anh-nike-flight',
                'cat_id' => 64, // Bóng Nike
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#78</li><li>Thương hiệu: Nike</li><li>Loại sản phẩm: Bóng thi đấu chính thức</li><li>Giải đấu: Premier League 2023/2024</li><li>Công nghệ: Aerowsculpt (Rãnh định hình đường bay)</li><li>Size bóng: Số 5 (Tiêu chuẩn FIFA Quality Pro)</li></ul>',
                'desc_detail' => '<p>Quả bóng đá Nike Flight Premier League là sự kết hợp hoàn hảo giữa công nghệ hàng đầu thế giới và thiết kế đột phá, mang đến quỹ đạo bay ổn định hơn 30% so với bóng truyền thống nhờ công nghệ Aerowsculpt độc quyền.</p><p><strong>Đặc tính kỹ thuật:</strong></p><p>- Các rãnh đúc định hình giúp phá vỡ lực cản của không khí giúp đường bay của bóng chuẩn xác hơn.</p><p>- Công nghệ mực in 3D Hyperflow tăng khả năng kiểm soát bóng trong mọi điều kiện thời tiết.</p><p>- Ruột bóng làm bằng chất liệu cao su latex cao cấp giữ hơi và giữ form cực tốt.</p>',
                'old_price' => 3200000,
                'new_price' => 2950000,
                'sizes' => [40],
            ],
            79 => [
                'name' => 'Quả Bóng Đá Adidas Euro 2024 Fussballliebe',
                'code' => 'TQ#79',
                'slug' => 'qua-bong-da-adidas-euro-2024-fussballliebe',
                'cat_id' => 63, // Bóng Adidas
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#79</li><li>Thương hiệu: Adidas</li><li>Ý nghĩa tên gọi: Fussballliebe</li><li>Giải đấu: VCK EURO 2024</li><li>Cấu trúc: Khâu tay nhiệt liền mạch không đường may</li><li>Size bóng: Số 5 tiêu chuẩn</li></ul>',
                'desc_detail' => '<p>Quả bóng thi đấu chính thức Adidas Fussballliebe tự hào sở hữu thiết kế lấy cảm hứng từ sự nhiệt huyết và gắn kết của bóng đá châu Âu. Thiết kế đầy màu sắc tượng trưng cho sự đa dạng và sống động của giải đấu EURO 2024.</p><p><strong>Ưu điểm nổi bật:</strong></p><p>- Bề mặt nhiệt liền mạch giúp quỹ đạo bay chuẩn xác hơn, chống thấm nước tuyệt đối bảo vệ trọng lượng bóng ổn định.</p><p>- Đạt tiêu chuẩn chất lượng cao nhất của FIFA (FIFA Quality Pro) về cân nặng, độ nảy và độ hấp thụ nước.</p><p>- Ruột bóng butyl cho khả năng giữ hơi vượt trội, giảm tần suất bơm bóng tối đa.</p>',
                'old_price' => 3400000,
                'new_price' => 3100000,
                'sizes' => [40],
            ],
            80 => [
                'name' => 'Găng Tay Thủ Môn Adidas Predator Pro',
                'code' => 'TQ#80',
                'slug' => 'gang-tay-thu-mon-adidas-predator-pro',
                'cat_id' => 51, // Găng tay thủ môn
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#80</li><li>Thương hiệu: Adidas</li><li>Kiểu ngón: Negative Cut (ôm sát ngón)</li><li>Mặt mút: Latex URG 2.0 (siêu dính)</li><li>Xương bảo vệ: Không xương</li><li>Size găng: 8, 9, 10</li></ul>',
                'desc_detail' => '<p>Găng tay thủ môn Adidas Predator Pro mang lại cho người gác đền sự tin cậy tuyệt đối với mặt mút URG 2.0 bám dính siêu hạng cả trong điều kiện ẩm ướt và khô ráo. Lớp gai silicone Demonskin ở mu bàn tay hỗ trợ những cú đấm bóng mạnh mẽ và chuẩn xác.</p><p><strong>Các tính năng chính:</strong></p><p>- Cổ chun đan co giãn dệt nguyên miếng thông thoáng ôm sát cổ tay không cần băng quấn.</p><p>- Negative Cut mang lại cảm giác chạm bóng chân thật nhất như bàn tay thứ hai.</p><p>- Lớp mút dày 4mm giảm chấn thương ngón tay và lòng bàn tay hiệu quả khi đối mặt những cú sút búa bổ.</p>',
                'old_price' => 2400000,
                'new_price' => 1950000,
                'sizes' => [38, 39, 40],
            ],
            81 => [
                'name' => 'Áo Đấu Đội Tuyển Anh Euro 2024',
                'code' => 'TQ#81',
                'slug' => 'ao-dau-doi-tuyen-anh-euro-2024',
                'cat_id' => 61, // Áo Đội tuyển Anh
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#81</li><li>Thương hiệu: Nike</li><li>Đội tuyển quốc gia: Anh (Three Lions)</li><li>Giải đấu: EURO 2024</li><li>Chất liệu: 100% sợi Polyester tái chế</li><li>Size áo: S, M, L, XL</li></ul>',
                'desc_detail' => '<p>Mẫu áo đấu ĐTQG Anh sân nhà tại vòng chung kết EURO 2024 kết hợp hài hòa giữa gam màu trắng tinh tế huyền thoại và viền cổ xanh lam sẫm cổ điển. Một thiết kế thanh lịch tôn vinh tinh thần bóng đá Anh kiên cường.</p><p><strong>Chi tiết thiết kế và công nghệ:</strong></p><p>- Công nghệ Nike Dri-FIT ADV đột phá giúp điều hòa nhiệt độ cơ thể cực đỉnh trong suốt quá trình hoạt động.</p><p>- Huy hiệu "Tam Sư" dệt nổi 3D sang trọng trước ngực cùng dải cờ nhỏ phía sau gáy áo độc đáo.</p><p>- Đường may phẳng mịn giảm ma sát tối đa với làn da mang lại sự dễ chịu nhất.</p>',
                'old_price' => 380000,
                'new_price' => 240000,
                'sizes' => [38, 39, 40],
            ],
            82 => [
                'name' => 'Tất Đá Bóng Chống Trượt Fox',
                'code' => 'TQ#82',
                'slug' => 'tat-da-bong-chong-truot-fox',
                'cat_id' => 66, // Tất đá bóng
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#82</li><li>Thương hiệu: Fox</li><li>Công nghệ: Hạt cao su silicone bám dính</li><li>Chất liệu: Cotton co giãn 4 chiều dày dặn</li><li>Màu sắc: Trắng, Đen, Xanh, Đỏ</li><li>Size: Free size</li></ul>',
                'desc_detail' => '<p>Tất chống trượt Fox là phụ kiện không thể thiếu của các cầu thủ phủi cũng như chuyên nghiệp. Hệ thống hạt cao su thông minh ở lòng tất giúp loại bỏ hoàn tượng trượt chân bên trong giày, ngăn ngừa phồng rộp và tăng lực bứt tốc.</p><p><strong>Tính năng ưu việt:</strong></p><p>- Hạt silicone siêu dính phân bổ khoa học bám chắc vào lót giày tạo liên kết vững vàng.</p><p>- Chất vải cotton chải kỹ thấm hút mồ hôi siêu tốc, giữ đôi chân luôn khô thoáng và thơm mát.</p><p>- Vùng cổ tất và mắt cá chân dệt bo chắc chắn giúp bảo vệ khớp, chống trầy xước va quệt hiệu quả.</p>',
                'old_price' => 95000,
                'new_price' => 65000,
                'sizes' => [38, 39, 40],
            ],
            83 => [
                'name' => 'Giày Bóng Đá Adidas Predator Accuracy.3 TF',
                'code' => 'TQ#83',
                'slug' => 'giay-bong-da-adidas-predator-accuracy-3-tf',
                'cat_id' => 71, // Giày Adidas Predator
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#83</li><li>Thương hiệu: Adidas</li><li>Loại đế: TF (Sân cỏ nhân tạo)</li><li>Đặc tính: Vân nổi High Definition Grip sút xoáy</li><li>Size giày: 39 - 44</li></ul>',
                'desc_detail' => '<p>Adidas Predator Accuracy.3 TF được thiết kế để mang đến những đường chuyền kiến tạo và cú dứt điểm chính xác đến từng milimet. Với kết cấu upper mềm mại phủ lớp gai nổi chiến thuật, đây là vũ khí tối thượng của các tiền vệ hào hoa.</p><p><strong>Điểm nổi bật sản phẩm:</strong></p><p>- Thân giày làm bằng vải dệt mềm mại phủ lớp phủ PU tăng độ bền và cảm giác bóng tự nhiên.</p><p>- Cổ chun co giãn ôm khít mắt cá chân giữ chân cố định vững vàng không bị xê dịch khi đổi hướng đột ngột.</p><p>- Đế ngoài đinh dăm cao su phân bố dày đặc cho độ bám sân nhân tạo tuyệt vời trong mọi thời tiết.</p>',
                'old_price' => 2200000,
                'new_price' => 1900000,
                'sizes' => [39, 40, 41, 42, 43, 44],
            ],
            84 => [
                'name' => 'Cúp Vô Địch Champions League Cao Cấp',
                'code' => 'TQ#84',
                'slug' => 'cup-vo-dich-champions-league-cao-cap',
                'cat_id' => 72, // Cúp lưu niệm
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#84</li><li>Tên cúp: UEFA Champions League (Cúp Tai Voi)</li><li>Chất liệu: Nhựa composite cao cấp phủ sơn bạc nano</li><li>Màu sắc: Bạc kim loại bóng gương</li><li>Kích thước: Cao 15cm / 32cm / 45cm</li><li>Mục đích: Trưng bày phòng khách, giải thưởng phong trào</li></ul>',
                'desc_detail' => '<p>Chiếc cúp vô địch UEFA Champions League mô phỏng tỷ lệ 1:1 chuẩn xác với độ hoàn thiện cực kỳ tinh xảo. Đây chính là biểu tượng kiêu hãnh của bóng đá cấp câu lạc bộ châu Âu, một vật phẩm trang trí vô cùng ý nghĩa cho người yêu thích môn thể thao vua.</p><p><strong>Đặc điểm sản phẩm:</strong></p><p>- Đường nét đúc tinh xảo, chữ khắc chìm rõ nét thể hiện đầy đủ tên các nhà vô địch lịch sử trên thân cúp.</p><p>- Lớp mạ bạc sáng bóng sang trọng, bền bỉ theo thời gian không bị xỉn màu hay oxy hóa.</p><p>- Đế gỗ đầm tay vững chãi mang lại cảm giác chân thực như chiếc cúp nguyên bản.</p>',
                'old_price' => 1500000,
                'new_price' => 950000,
                'sizes' => [38, 39, 40],
            ],
            85 => [
                'name' => 'Bộ Quần Áo Bóng Đá Việt Nam Sân Nhà',
                'code' => 'TQ#85',
                'slug' => 'bo-quan-ao-bong-da-viet-nam-san-nha',
                'cat_id' => 60, // Áo Đội tuyển Việt Nam
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#85</li><li>Thương hiệu: Grand Sport / Jogarbola chính hãng</li><li>Tông màu: Đỏ truyền thống tự hào</li><li>Chất liệu: Thun lạnh co giãn 4 chiều</li><li>Thành phần: 1 áo đấu và 1 quần đùi</li><li>Size áo: M, L, XL, XXL</li></ul>',
                'desc_detail' => '<p>Bộ trang phục thi đấu sân nhà của ĐTQG Việt Nam khoác lên mình màu cờ sắc áo đỏ rực lửa đầy tự hào, mang thiết kế trẻ trung năng động tôn vinh sức mạnh của các chiến binh Sao Vàng quả cảm trên đấu trường quốc tế.</p><p><strong>Chi tiết kỹ thuật nổi trội:</strong></p><p>- Vải mè dệt kim siêu thoáng khí giúp thoát nhiệt cực nhanh và chống bết dính mồ hôi khi chạy mệt.</p><p>- Logo Quốc kỳ Việt Nam được dệt sắc sảo bên ngực trái kèm viền vàng kim quý phái lịch lãm.</p><p>- Dễ dàng giặt sạch, nhanh khô thích hợp cho các hoạt động thể thao cường độ cao ngoài trời.</p>',
                'old_price' => 280000,
                'new_price' => 195000,
                'sizes' => [38, 39, 40],
            ],
            86 => [
                'name' => 'Găng Tay Thủ Môn Nike Vapor Grip 3',
                'code' => 'TQ#86',
                'slug' => 'gang-tay-thu-mon-nike-vapor-grip-3',
                'cat_id' => 51, // Găng tay thủ môn
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#86</li><li>Thương hiệu: Nike</li><li>Công nghệ: Grip3 (Mút cuộn ôm 3 ngón ngoài)</li><li>Mặt mút: 4mm Contact Plus Foam cực dính</li><li>Cổ tay: Băng quấn cổ tay dán linh hoạt</li><li>Size: 8, 9, 10</li></ul>',
                'desc_detail' => '<p>Găng tay thủ môn Nike Vapor Grip 3 là dòng sản phẩm cao cấp đồng hành cùng nhiều thủ môn hàng đầu thế giới nhờ công nghệ Grip3 ôm ngón độc đáo, tạo ra diện tích tiếp xúc bóng tối đa giúp các pha bắt bóng trở nên dính chặt an toàn.</p><p><strong>Tính năng cốt lõi:</strong></p><p>- Contact Plus Foam dày 4mm giúp giảm chấn lực cực tốt trước những cú sút căng nhất.</p><p>- Thiết kế thông gió đặc trưng ở mu bàn tay giúp luồng không khí dễ lưu thông giữ mát đôi tay.</p><p>- Cổ tay thun co giãn điều chỉnh tự do tạo điểm tựa ôm cổ tay êm ái chống bong gân trật khớp.</p>',
                'old_price' => 2500000,
                'new_price' => 2150000,
                'sizes' => [38, 39, 40],
            ],
            87 => [
                'name' => 'Cúp Vô Địch World Cup Lưu Niệm mạ vàng',
                'code' => 'TQ#87',
                'slug' => 'cup-vo-dich-world-cup-luu-niem-ma-vang',
                'cat_id' => 72, // Cúp lưu niệm
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#87</li><li>Sản phẩm: Mô hình Cúp vô địch bóng đá thế giới FIFA World Cup</li><li>Chất liệu: Nhựa resin nguyên khối mạ vàng điện hóa nano</li><li>Chiều cao: 21cm / 36cm (Tỷ lệ 1:1 chuẩn FIFA)</li><li>Trọng lượng: Thiết kế đầm tay chắc chắn</li><li>Mục đích: Sưu tầm, trưng bày lưu niệm</li></ul>',
                'desc_detail' => '<p>Cúp vô địch thế giới FIFA World Cup mạ vàng tinh xảo mô phỏng hoàn mỹ hình dáng hai vận động viên nâng cao quả địa cầu thiêng liêng đầy tự hào. Đây chính là biểu tượng khát vọng cháy bỏng cao quý nhất của làng thể thao thế giới.</p><p><strong>Đặc điểm nổi bật:</strong></p><p>- Công nghệ mạ vàng nano bóng sáng lộng lẫy, giữ màu cực lâu không sợ bị mài mòn bạc màu.</p><p>- Bề mặt cúp trơn láng sắc nét từng đường vân lục địa trên quả địa cầu.</p><p>- Đi kèm hộp đựng bọc nhung lót xốp chống sốc sang trọng lịch lãm phù hợp làm quà tặng bóng đá cao cấp.</p>',
                'old_price' => 850000,
                'new_price' => 600000,
                'sizes' => [38, 39, 40],
            ],
            88 => [
                'name' => 'Băng Quấn Cổ Tay Tránh Chấn Thương',
                'code' => 'TQ#88',
                'slug' => 'bang-quan-co-tay-tranh-chan-thuong',
                'cat_id' => 50, // Phụ kiện bóng đá
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#88</li><li>Thương hiệu: Aolikes / Valeo cao cấp</li><li>Chất liệu: Sợi Nylon đàn hồi cao</li><li>Công dụng: Cố định cổ tay, tránh chấn thương khớp</li><li>Quy cách: Gồm 2 cuộn băng cổ tay</li><li>Màu sắc: Đen</li></ul>',
                'desc_detail' => '<p>Băng quấn cổ tay thể thao là trợ thủ đắc lực bảo vệ xương khớp cổ tay cho các vận động viên, thủ môn khi phải thực hiện các pha cản phá bóng mạnh mẽ hoặc đẩy tạ cường độ lớn, giảm thiểu nguy cơ trật khớp, bong gân tối đa.</p><p><strong>Ưu điểm sản phẩm:</strong></p><p>- Độ co giãn đàn hồi cực cao thích ứng êm ái vừa vặn cho mọi kích cỡ cổ tay nam nữ.</p><p>- Bề mặt miếng dán Velcro thế hệ mới siêu bền chặt không lo bị tuột rơi giữa chừng trận đấu.</p><p>- Chất vải thoáng khí hút mồ hôi siêu nhanh không gây ngứa hay hăm bí da.</p>',
                'old_price' => 150000,
                'new_price' => 95000,
                'sizes' => [38, 39, 40],
            ],
            89 => [
                'name' => 'Bóng Puma Orbita Serie A Cực Bền',
                'code' => 'TQ#89',
                'slug' => 'bong-puma-orbita-serie-a-cuc-ben',
                'cat_id' => 73, // Bóng Puma
                'desc_quick' => '<ul><li>Mã sản phẩm: TQ#89</li><li>Thương hiệu: Puma</li><li>Loại sản phẩm: Bóng thi đấu chính thức Serie A</li><li>Công nghệ: Cấu trúc 12 bảng ghép tối ưu hóa</li><li>Chất liệu: Da PU và màng bọt POE chịu mài mòn tốt</li><li>Size bóng: Số 5 tiêu chuẩn</li></ul>',
                'desc_detail' => '<p>Quả bóng đá Puma Orbita Serie A mang tính biểu tượng đặc trưng của giải đấu khắc nghiệt hàng đầu nước Ý. Kết cấu bóng được nghiên cứu đột phá giúp tăng tính đàn hồi lực nảy chuẩn mực đưa bóng đi với gia tốc ổn định vượt trội.</p><p><strong>Tính năng chính:</strong></p><p>- 12 tấm da PU được ghép nén ép nhiệt kín khít hoàn hảo chống ngậm nước bảo đảm trọng lượng tiêu chuẩn.</p><p>- Vân nổi 3D mờ trên vỏ bóng tối ưu cảm giác chạm chân chân thực cho tiền đạo dễ dàng khống chế sút bóng xoáy hiểm hóc.</p><p>- Ruột bóng chất liệu cao su tự nhiên cao cấp cho độ nảy đầm đạt chứng chỉ FIFA Quality Pro khắt khe nhất.</p>',
                'old_price' => 3200000,
                'new_price' => 2800000,
                'sizes' => [40],
            ],
        ];

        // Map product IDs to available image sets
        $imageMapping = [
            75 => 1,   // Nike Mercurial
            76 => 2,   // Real Madrid
            77 => 3,   // Barcelona
            78 => 4,   // Nike Flight Ball
            79 => 5,   // Adidas Euro Ball
            80 => 6,   // Adidas Predator Gloves
            81 => 7,   // England Euro
            82 => 8,   // Fox Socks
            83 => 9,   // Adidas Predator Accuracy
            84 => 10,  // Champions League Cup
            85 => 11,  // Vietnam Uniform
            86 => 12,  // Nike Vapor Gloves
            87 => 13,  // World Cup Gold
            88 => 14,  // Wrist Wrap
            89 => 5,   // Puma Orbita (reuse sp5)
        ];

        foreach ($soccerProducts as $id => $pData) {
            // Get image set number for this product
            $imageSetNum = $imageMapping[$id] ?? 1;
            
            // Build thumbnail paths
            $thumbMain = 'uploads/sp' . $imageSetNum . '-main.jpg';
            $thumbDetails = [];
            
            // Add available detail images for this product
            for ($i = 1; $i <= 4; $i++) {
                $detailPath = 'uploads/sp' . $imageSetNum . '-detail' . $i . '.jpg';
                // Check if this detail image exists in our array
                if (in_array($detailPath, [
                    'uploads/sp1-detail1.jpg', 'uploads/sp1-detail2.jpg', 'uploads/sp1-detail3.jpg', 'uploads/sp1-detail4.jpg',
                    'uploads/sp2-detail1.jpg', 'uploads/sp2-detail2.jpg', 'uploads/sp2-detail3.jpg', 'uploads/sp2-detail4.jpg',
                    'uploads/sp3-detail1.jpg', 'uploads/sp3-detail2.jpg', 'uploads/sp3-detail3.jpg', 'uploads/sp3-detail4.jpg',
                    'uploads/sp4-detail1.jpg', 'uploads/sp4-detail2.jpg', 'uploads/sp4-detail3.jpg', 'uploads/sp4-main.jpg',
                    'uploads/sp5-detail1.jpg', 'uploads/sp5-detail2.jpg', 'uploads/sp5-detail3.jpg', 'uploads/sp5-main.jpg',
                    'uploads/sp6-detail1.jpg', 'uploads/sp6-detail2.jpg', 'uploads/sp6-detail3.jpg', 'uploads/sp6-detail4.jpg', 'uploads/sp6-detail5.jpg',
                    'uploads/sp7-detail1.jpg', 'uploads/sp7-detail2.jpg', 'uploads/sp7-detail3.jpg', 'uploads/sp7-detail4.jpg',
                    'uploads/sp8-detail1.jpg', 'uploads/sp8-detail3.jpg', 'uploads/sp8-main.jpg',
                    'uploads/sp9-detail1.jpg', 'uploads/sp9-detail2.jpg', 'uploads/sp9-detail3.jpg', 'uploads/sp9-detail4.jpg',
                    'uploads/sp10-detail1.jpg', 'uploads/sp10-detail2.jpg', 'uploads/sp10-detail3.jpg', 'uploads/sp10-detail4.jpg',
                    'uploads/sp11-detail1.jpg', 'uploads/sp11-detail2.jpg', 'uploads/sp11-main.jpg',
                    'uploads/sp12-detail1.jpg', 'uploads/sp12-detail2.jpg', 'uploads/sp12-main.jpg',
                    'uploads/sp13-detail1.jpg', 'uploads/sp13-main.jpg',
                    'uploads/sp14-detail1.jpg', 'uploads/sp14-detail2.jpg', 'uploads/sp14-main.jpg',
                ])) {
                    $thumbDetails[] = $detailPath;
                }
            }

            // Update the product basic attributes
            $product = Product::updateOrCreate(
                ['id' => $id],
                [
                    'name' => $pData['name'],
                    'code' => $pData['code'],
                    'slug' => $pData['slug'],
                    'cat_id' => $pData['cat_id'],
                    'desc_quick' => $pData['desc_quick'],
                    'desc_detail' => $pData['desc_detail'],
                    'old_price' => $pData['old_price'],
                    'new_price' => $pData['new_price'],
                    'discount' => round((($pData['old_price'] - $pData['new_price']) / $pData['old_price']) * 100),
                    'status' => 1,
                    // If migration has been run, set size column as well
                    'size' => implode(',', $pData['sizes']),
                    'thumb_main' => $thumbMain,
                    'thumb_detail' => json_encode($thumbDetails),
                ]
            );

            // Re-sync product options/configurations (size prices)
            // Clear existing ones for this product
            DB::table('product_config')->where('product_id', $id)->delete();

            // Link to selected configs
            foreach ($pData['sizes'] as $sizeNum) {
                // Determine price for this size
                $price = $pData['new_price'];
                if ($sizeNum == 39) {
                    $price += 50000;
                } elseif ($sizeNum == 40) {
                    $price += 100000;
                }

                DB::table('product_config')->insert([
                    'product_id' => $id,
                    'config_id' => $sizeNum,
                    'price' => $price,
                ]);
            }
        }
    }
}
