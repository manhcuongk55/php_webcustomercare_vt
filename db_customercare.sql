-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2018 at 06:00 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_customercare`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group` tinyint(4) NOT NULL,
  `cdate` date NOT NULL,
  `isactive` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `name`, `alias`, `group`, `cdate`, `isactive`) VALUES
(1, 'Thông tin chung cá nhân', 'thong_tin_chung_ca_nhan', 0, '2018-04-01', 1),
(2, 'Sở thích', 'so_thich', 0, '2018-04-01', 1),
(3, 'Quan hệ gia đình', 'quan_he_gia_dinh', 0, '2018-04-01', 1),
(4, 'Quá trình học tập', 'qua_trinh_hoc_tap', 0, '2018-04-01', 1),
(5, 'Lý lịch công tác', 'ly_lich_cong_tac', 0, '2018-04-01', 1),
(6, 'Quan hệ xã hội', 'quan_he_xa_hoi', 0, '2018-04-01', 1),
(7, 'Thông tin chung doanh nghiệp', 'thong_tin_chung_doanh_nghiep', 1, '2018-04-01', 1),
(8, 'Thông tin người đại diện doanh nghiệp', 'thong_tin_nguoi_dai_dien_doanh_nghiep', 1, '2018-04-01', 1),
(9, 'Tổ chức đối tác của doanh nghiệp', 'to_chuc_doi_tac_cua_doanh_nghiep', 1, '2018-04-01', 1),
(10, 'Thông tin chung tổ chức', 'thong_tin_chung_to_chuc', 2, '2018-04-09', 1),
(11, 'Thông tin người đại diện tổ chức', 'thong_tin_nguoi_dai_dien_to_chuc', 2, '2018-04-09', 1),
(12, 'Tổ chức đối tác của tổ chức', 'to_chuc_doi_tac_cua_to_chuc', 2, '2018-04-09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_common`
--

CREATE TABLE `tbl_common` (
  `id` int(10) NOT NULL,
  `sub_cat_id` int(10) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_common`
--

INSERT INTO `tbl_common` (`id`, `sub_cat_id`, `name`) VALUES
(1, 4, 'Môn 1'),
(2, 4, 'Môn 2'),
(3, 5, 'Món 1'),
(4, 5, 'Món 2'),
(5, 8, 'Xe 1'),
(6, 8, 'Xe 2'),
(7, 7, 'Quyển 1'),
(8, 9, 'Điện thoại 1'),
(9, 11, 'Giày 1'),
(10, 7, 'Quyển 2'),
(11, 8, 'Xe 3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id` int(10) NOT NULL,
  `mem_id` int(10) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `fullname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(11) NOT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `diedate` date NOT NULL,
  `birthday_family` text NOT NULL,
  `diedate_family` text NOT NULL,
  `cdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id`, `mem_id`, `type`, `fullname`, `birthday`, `phone`, `gender`, `diedate`, `birthday_family`, `diedate_family`, `cdate`) VALUES
(25, 2, 0, 'Mai Thi En', '1991-06-28', '0988777888', 0, '1970-01-01', '', '', '2018-04-08'),
(26, 2, 1, 'Viettel', '1970-01-01', '0988777888', 0, '0000-00-00', '', '', '2018-04-09'),
(28, 2, 2, 'Bộ thông tin và truyền thông', '2018-04-10', '0234777888', 0, '0000-00-00', '', '', '2018-04-10'),
(29, 2, 0, 'Mai Ngọc Tuân ', '1981-01-01', '0902567868', 0, '1970-01-01', '', '', '2018-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_detail`
--

CREATE TABLE `tbl_customer_detail` (
  `id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `sub_cat_id` int(10) NOT NULL,
  `json` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_customer_detail`
--

INSERT INTO `tbl_customer_detail` (`id`, `customer_id`, `sub_cat_id`, `json`, `cdate`) VALUES
(1655, 28, 33, '{"sub_cat_id":"33","thong_tin_co_ban":{"ten_to_chuc":"Bộ thông tin và truyền thông","loai_hinh_hoat_dong":"Kinh doanh viễn thông","cap_do":"chinh_phu","ngay_thanh_lap":"10-04-2018","dia_chi":"Hai Bà Trưng","so_dien_thoai":"0234777888","tai_khoan_ngan_hang":"0987666777","mo_hinh_to_chuc":"uploads/avatar/mohinhtochuc.png"}}', '2018-04-11'),
(1656, 28, 34, '{"sub_cat_id":"34","thong_tin_khac":{"chi_phi_mua_sam":"8000"}}', '2018-04-11'),
(1657, 28, 35, '{"sub_cat_id":"35","thong_tin_gan_dinh_danh_co_the":[{"ho_ten":"Trần Hoài Nam","bi_danh":"Nam bụng phệ","ngay_sinh":"01-04-2018","menh":"Thiên thượng hỏa","noi_sinh":"HA NOI","gioi_tinh":"0","tien_su_benh":"chưa có thông tin"}]}', '2018-04-11'),
(1658, 28, 36, '{"sub_cat_id":"36","thong_tin_khac":[{"chuc_danh":"Giam đốc","so_dien_thoai":"09889997777","noi_o_hien_tai":"Hà Nội","tinh_trang_hon_nhan":"da_ket_hon","so_thich_dac_biet":"Thích nhậu"}]}', '2018-04-11'),
(1659, 28, 37, '{"sub_cat_id":"37","thong_tin_dinh_danh_gan_to_chu":[{"ten_to_chuc":"Vinamilk","loai_hinh_kinh_doanh":"Sữa","cap_do":"chinh_phu","ngay_thanh_lap":"10-04-2018","dia_chi":"Ha noi","so_dien_thoai":"0988866655","tai_khoan_ngan_hang":"63243879"}]}', '2018-04-11'),
(1660, 28, 38, '{"sub_cat_id":"38","thong_tin_nguoi_dai_dien_cua_doi_tac":[{"ho_ten":"Trần Công Phước","bi_danh":"Phước mom","ngay_sinh":"11-04-2018","menh":"Thiên thượng hỏa","gioi_tinh":"da_ket_hon","tinh_trang_hon_nhan":"0","so_thich_dac_biet":"Chưa có thông tin"}]}', '2018-04-11'),
(1667, 26, 24, '{"sub_cat_id":"24","thong_tin_co_ban":{"ten_doanh_nghiep":"Viettel","loai_hinh_kinh_doanh":"Viễn thông","cap_do":"tap_doan","ngay_thanh_lap":"","dia_chi":"Trần Hữu Dực","giay_phep":"GiayPhep01","so_dien_thoai":"0988777888","ma_so_thue":"Masothue","tai_khoan_ngan_hang":"Vietcombank","mo_hinh_to_chuc":""}}', '2018-04-11'),
(1668, 26, 25, '{"sub_cat_id":"25","thong_tin_khac":{"doanh_so":"doanhso","chi_phi_hoat_dong_mua_sam":"chiphihoatdong","thu_hang":"1000"}}', '2018-04-11'),
(1669, 26, 26, '{"sub_cat_id":"26","thong_tin_gan_dinh_danh_co_the":[{"ho_ten":"Tran Xuan Bach","bi_danh":"bachbanhbao","ngay_sinh":"11-04-2018","menh":"Thiên thượng hỏa","noi_sinh":"Chua co thong tin","gioi_tinh":"0","tien_su_benh":"Chua co thong tin"}]}', '2018-04-11'),
(1670, 26, 27, '{"sub_cat_id":"27","thong_tin_khac":[{"chuc_danh":"Giam doc","so_dien_thoai":"0987666555","noi_o_hien_tai":"Chua co thong tin","tinh_trang_ket_hon":"da_ket_hon","so_thich_dac_biet":"Chua co thong tin"}]}', '2018-04-11'),
(1671, 26, 31, '{"sub_cat_id":"31","thong_tin_dinh_danh_gan_voi_to_chuc":[{"ten_doanh_nghiep":"Viettel","loai_hinh_kinh_doanh":"Vien thong","cap_do":"tap_doan","ngay_thanh_lap":"11-04-2018","dia_chi":"Ha Noi","giay_phep":"GP01","so_dien_thoai":"0987765444","ma_so_thue":"MST","tai_khoan_ngan_hang":"035180099888"}]}', '2018-04-11'),
(1672, 26, 32, '{"sub_cat_id":"32","thong_tin_nguoi_dai_dien_doi_tac":[{"ho_ten":"FPT","bi_danh":"Ti ti","ngay_sinh":"11-04-2018","menh":"Thoa xuyến kim","gioi_tinh":"0","tinh_trang_ket_hon":"da_ket_hon","so_thich_dac_biet":"OK"}]}', '2018-04-11'),
(1696, 25, 1, '{"sub_cat_id":"1","thong_tin_gan_dinh_danh_co_the":{"ho_ten":"Mai Thi En","bi_danh":"Bach Banh Bao","hinh_anh":"uploads/avatar/image.png","ngay_sinh":"28-06-1991","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"La Sơn Bình Lục Hà Nam","gioi_tinh":"0","chieu_cao":"160","can_nang":"62","mau_toc":"Đen","kieu_toc":"Vuốt","tien_su_benh":"Chưa có thông tin"}}', '2018-04-11'),
(1697, 25, 2, '{"sub_cat_id":"2","thong_tin_quan_ly_ca_nhan_trong_xa_hoi":{"so_cmnd":"168373109","so_ho_chieu":"11223344","dan_toc":"Kinh","ton_giao":"Không","quoc_tich":"Việt Nam","dk_ho_khau_thuong_chu":"La sơn - Bình Lục Hà Nam","noi_o_hien_tai":"Cổ nhuế 2"}}', '2018-04-11'),
(1698, 25, 3, '{"sub_cat_id":"3","thong_tin_xa_hoi_hien_tai":{"dien_thoai":"0988777888","email":"txbachit@gmail.com","tk_ngan_hang":"119900228890767","ma_so_thue":"78499362729","tinh_trang_ket_hon":"da_ket_hon","lan_ket_hon":"1","noi_ket_hon":"nha_hang","trinh_do_hoc_van":"dai_hoc","don_vi_cong_tac":"FPT","vi_tri_cong_tac":"Dev"}}', '2018-04-11'),
(1699, 25, 4, '{"sub_cat_id":"4","the_thao":[{"ten_mon_the_thao":"Bóng bàn","dac_diem_luu_y":"Thuận tay trái"},{"ten_mon_the_thao":"Tennis","dac_diem_luu_y":"Sân nện"}]}', '2018-04-11'),
(1700, 25, 5, '{"sub_cat_id":"5","am_thuc":[{"ten_mon":"Vit quay","ten_quoc_gia":"Trung Quoc","dac_diem_luu_y":"Den"},{"ten_mon":"Vit nuong","ten_quoc_gia":"Viet nam","dac_diem_luu_y":"Do"}]}', '2018-04-11'),
(1701, 25, 6, '{"sub_cat_id":"6","nghe_thuat":""}', '2018-04-11'),
(1702, 25, 7, '{"sub_cat_id":"7","sach":[{"the_loai":"Lập trình C","tac_gia":"","tac_pham":"","dac_diem_luu_y":""},{"the_loai":"","tac_gia":"","tac_pham":"","dac_diem_luu_y":""}]}', '2018-04-11'),
(1703, 25, 8, '{"sub_cat_id":"8","xe":[{"hang_xe":"Mecerdes","dong_xe":"E300","mau_sac":"Đen"},{"hang_xe":"","dong_xe":"","mau_sac":""},{"hang_xe":"","dong_xe":"","mau_sac":""}]}', '2018-04-11'),
(1704, 25, 9, '{"sub_cat_id":"9","dien_thoai":[{"hang":"","model":"","mau_sac":""}]}', '2018-04-11'),
(1705, 25, 10, '{"sub_cat_id":"10","thoi_trang":""}', '2018-04-11'),
(1706, 25, 11, '{"sub_cat_id":"11","giay":[{"thuong_hieu":"","size":"","mau_sac":"","loai_giay":""}]}', '2018-04-11'),
(1707, 25, 12, '{"sub_cat_id":"12","nuoc_hoa":""}', '2018-04-11'),
(1708, 25, 13, '{"sub_cat_id":"13","do_uong":""}', '2018-04-11'),
(1709, 25, 14, '{"sub_cat_id":"14","ca_hat":""}', '2018-04-11'),
(1710, 25, 15, '{"sub_cat_id":"15","kinh_deo":""}', '2018-04-11'),
(1711, 25, 16, '{"sub_cat_id":"16","dong_ho":""}', '2018-04-11'),
(1712, 25, 17, '{"sub_cat_id":"17","am_nhac":""}', '2018-04-11'),
(1713, 25, 18, '{"sub_cat_id":"18","du_lich":""}', '2018-04-11'),
(1714, 25, 19, '{"sub_cat_id":"19","thong_tin_gan_dinh_danh_co_the":[{"ho_ten":"Trần Văn Minh","bi_danh":"Minh còi","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""}]}', '2018-04-11'),
(1715, 25, 20, '{"sub_cat_id":"20","thong_tin_khac":[{"dien_thoai":"0984343049","noi_o_hien_tai":"Lẫm Hạ","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""}]}', '2018-04-11'),
(1716, 25, 21, '{"sub_cat_id":"21","qua_trinh_hoc_tap":[{"from_year":"1950","to_year":"1951","cap_hoc":"cap1","truong_hoc":"La Sơn","quoc_gia":"VN","chuyen_nganh":"CNTT"},{"from_year":"1951","to_year":"1952","cap_hoc":"cap2","truong_hoc":"THCS La Son","quoc_gia":"Viet Nam","chuyen_nganh":"CNTT"},{"from_year":"","to_year":"","cap_hoc":"","truong_hoc":"","quoc_gia":"","chuyen_nganh":""},{"from_year":"","to_year":"","cap_hoc":"","truong_hoc":"","quoc_gia":"","chuyen_nganh":""},{"from_year":"","to_year":"","cap_hoc":"","truong_hoc":"","quoc_gia":"","chuyen_nganh":""}]}', '2018-04-11'),
(1717, 25, 22, '{"sub_cat_id":"22","ly_lich_cong_tac":[{"from_year":"1999","to_year":"2000","vi_tri_cong_tac":"Bộ trưởng GTVT","don_vi_cong_tac":"Bộ Giao Thông","khen_thuong":"Huân chương lao động","ky_luat":"Chưa có thông tin","dia_chi":"HÀ NỘI"},{"from_year":"1951","to_year":"1952","vi_tri_cong_tac":"GIam doc","don_vi_cong_tac":"Viettel","khen_thuong":"khong","ky_luat":"Khong","dia_chi":"Ha noi"},{"from_year":"","to_year":"","vi_tri_cong_tac":"","don_vi_cong_tac":"","khen_thuong":"","ky_luat":"","dia_chi":""},{"from_year":"","to_year":"","vi_tri_cong_tac":"","don_vi_cong_tac":"","khen_thuong":"","ky_luat":"","dia_chi":""},{"from_year":"","to_year":"","vi_tri_cong_tac":"","don_vi_cong_tac":"","khen_thuong":"","ky_luat":"","dia_chi":""}]}', '2018-04-11'),
(1718, 25, 23, '{"sub_cat_id":"23","quan_he_xa_hoi":[{"cap_do_quan_he":"ca_nhan","hinh_thuc_quan_he":"truc_tiep","dau_moi":"Hoang Anh Dung","loai_quan_he":"cap_tren","so_dien_thoai":"0988765444","co_quan":"VT","dia_chi":"Ha noi"},{"cap_do_quan_he":"nha_nuoc","hinh_thuc_quan_he":"truc_tiep","dau_moi":"","loai_quan_he":"ban_be","so_dien_thoai":"","co_quan":"","dia_chi":""},{"cap_do_quan_he":"nha_nuoc","hinh_thuc_quan_he":"truc_tiep","dau_moi":"","loai_quan_he":"ban_be","so_dien_thoai":"","co_quan":"","dia_chi":""},{"cap_do_quan_he":"nha_nuoc","hinh_thuc_quan_he":"truc_tiep","dau_moi":"","loai_quan_he":"ban_be","so_dien_thoai":"","co_quan":"","dia_chi":""},{"cap_do_quan_he":"nha_nuoc","hinh_thuc_quan_he":"truc_tiep","dau_moi":"","loai_quan_he":"ban_be","so_dien_thoai":"","co_quan":"","dia_chi":""}]}', '2018-04-11'),
(1742, 29, 1, '{"sub_cat_id":"1","thong_tin_gan_dinh_danh_co_the":{"ho_ten":"Mai Ngọc Tuân ","bi_danh":"Tuân Bit","hinh_anh":"","ngay_sinh":"01-01-1981","ngay_mat":"","menh":"Thạch Lựu mộc","noi_sinh":"Thanh Hóa","gioi_tinh":"0","chieu_cao":"167","can_nang":"80","mau_toc":"Đen","kieu_toc":"Ba phân","tien_su_benh":"Chưa có"}}', '2018-04-11'),
(1743, 29, 2, '{"sub_cat_id":"2","thong_tin_quan_ly_ca_nhan_trong_xa_hoi":{"so_cmnd":"Chưa có thông tin ","so_ho_chieu":"Chưa có thông tin","dan_toc":"Kinh","ton_giao":"Không","quoc_tich":"Việt Nam","dk_ho_khau_thuong_chu":"Thanh Hóa","noi_o_hien_tai":"Hà Nội"}}', '2018-04-11'),
(1744, 29, 3, '{"sub_cat_id":"3","thong_tin_xa_hoi_hien_tai":{"dien_thoai":"0902567868","email":"Chưa có thông tin","tk_ngan_hang":"Chưa có thông tin","ma_so_thue":"Chưa có thông tin","tinh_trang_ket_hon":"da_ket_hon","lan_ket_hon":"1","noi_ket_hon":"nha_rieng","trinh_do_hoc_van":"thac_si","don_vi_cong_tac":"Chưa có thông tin","vi_tri_cong_tac":"Chưa có thông tin"}}', '2018-04-11'),
(1745, 29, 4, '{"sub_cat_id":"4","the_thao":[{"ten_mon_the_thao":"","dac_diem_luu_y":""},{"ten_mon_the_thao":"","dac_diem_luu_y":""}]}', '2018-04-11'),
(1746, 29, 5, '{"sub_cat_id":"5","am_thuc":[{"ten_mon":"","ten_quoc_gia":"","dac_diem_luu_y":""},{"ten_mon":"","ten_quoc_gia":"","dac_diem_luu_y":""}]}', '2018-04-11'),
(1747, 29, 6, '{"sub_cat_id":"6","nghe_thuat":""}', '2018-04-11'),
(1748, 29, 7, '{"sub_cat_id":"7","sach":[{"the_loai":"","tac_gia":"","tac_pham":"","dac_diem_luu_y":""},{"the_loai":"","tac_gia":"","tac_pham":"","dac_diem_luu_y":""}]}', '2018-04-11'),
(1749, 29, 8, '{"sub_cat_id":"8","xe":[{"hang_xe":"","dong_xe":"","mau_sac":""},{"hang_xe":"","dong_xe":"","mau_sac":""},{"hang_xe":"","dong_xe":"","mau_sac":""}]}', '2018-04-11'),
(1750, 29, 9, '{"sub_cat_id":"9","dien_thoai":[{"hang":"","model":"","mau_sac":""}]}', '2018-04-11'),
(1751, 29, 10, '{"sub_cat_id":"10","thoi_trang":""}', '2018-04-11'),
(1752, 29, 11, '{"sub_cat_id":"11","giay":[{"thuong_hieu":"","size":"","mau_sac":"","loai_giay":""}]}', '2018-04-11'),
(1753, 29, 12, '{"sub_cat_id":"12","nuoc_hoa":""}', '2018-04-11'),
(1754, 29, 13, '{"sub_cat_id":"13","do_uong":""}', '2018-04-11'),
(1755, 29, 14, '{"sub_cat_id":"14","ca_hat":""}', '2018-04-11'),
(1756, 29, 15, '{"sub_cat_id":"15","kinh_deo":""}', '2018-04-11'),
(1757, 29, 16, '{"sub_cat_id":"16","dong_ho":""}', '2018-04-11'),
(1758, 29, 17, '{"sub_cat_id":"17","am_nhac":""}', '2018-04-11'),
(1759, 29, 18, '{"sub_cat_id":"18","du_lich":""}', '2018-04-11'),
(1760, 29, 19, '{"sub_cat_id":"19","thong_tin_gan_dinh_danh_co_the":[{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""},{"ho_ten":"","bi_danh":"","ngay_sinh":"","ngay_mat":"","menh":"Thoa xuyến kim","noi_sinh":"","tien_su_benh":""}]}', '2018-04-11'),
(1761, 29, 20, '{"sub_cat_id":"20","thong_tin_khac":[{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""},{"dien_thoai":"","noi_o_hien_tai":"","don_vi_cong_tac":"","vi_tri_cong_tac":"","so_thich_dac_biet":""}]}', '2018-04-11'),
(1762, 29, 21, '{"sub_cat_id":"21","qua_trinh_hoc_tap":[{"from_year":"","to_year":"","cap_hoc":"","truong_hoc":"","quoc_gia":"","chuyen_nganh":""},{"from_year":"","to_year":"","cap_hoc":"","truong_hoc":"","quoc_gia":"","chuyen_nganh":""},{"from_year":"","to_year":"","cap_hoc":"","truong_hoc":"","quoc_gia":"","chuyen_nganh":""},{"from_year":"","to_year":"","cap_hoc":"","truong_hoc":"","quoc_gia":"","chuyen_nganh":""},{"from_year":"","to_year":"","cap_hoc":"","truong_hoc":"","quoc_gia":"","chuyen_nganh":""}]}', '2018-04-11'),
(1763, 29, 22, '{"sub_cat_id":"22","ly_lich_cong_tac":[{"from_year":"","to_year":"","vi_tri_cong_tac":"","don_vi_cong_tac":"","khen_thuong":"","ky_luat":"","dia_chi":""},{"from_year":"","to_year":"","vi_tri_cong_tac":"","don_vi_cong_tac":"","khen_thuong":"","ky_luat":"","dia_chi":""},{"from_year":"","to_year":"","vi_tri_cong_tac":"","don_vi_cong_tac":"","khen_thuong":"","ky_luat":"","dia_chi":""},{"from_year":"","to_year":"","vi_tri_cong_tac":"","don_vi_cong_tac":"","khen_thuong":"","ky_luat":"","dia_chi":""},{"from_year":"","to_year":"","vi_tri_cong_tac":"","don_vi_cong_tac":"","khen_thuong":"","ky_luat":"","dia_chi":""}]}', '2018-04-11'),
(1764, 29, 23, '{"sub_cat_id":"23","quan_he_xa_hoi":[{"dau_moi":"","so_dien_thoai":"","co_quan":"","dia_chi":""},{"dau_moi":"","so_dien_thoai":"","co_quan":"","dia_chi":""},{"dau_moi":"","so_dien_thoai":"","co_quan":"","dia_chi":""},{"dau_moi":"","so_dien_thoai":"","co_quan":"","dia_chi":""},{"dau_moi":"","so_dien_thoai":"","co_quan":"","dia_chi":""}]}', '2018-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_field_infomation`
--

CREATE TABLE `tbl_field_infomation` (
  `id` int(10) NOT NULL,
  `sub_cat_id` int(10) NOT NULL,
  `alias` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data_type` varchar(20) NOT NULL,
  `sort` int(11) NOT NULL,
  `isactive` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_field_infomation`
--

INSERT INTO `tbl_field_infomation` (`id`, `sub_cat_id`, `alias`, `name`, `data_type`, `sort`, `isactive`) VALUES
(1, 1, 'ho_ten', 'Họ tên', 'text', 1, 1),
(2, 1, 'bi_danh', 'Bí danh', 'text', 2, 1),
(3, 1, 'hinh_anh', 'Hình ảnh đại diện', 'file', 3, 1),
(4, 1, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(5, 1, 'ngay_mat', 'Ngày mất', 'text', 5, 1),
(6, 1, 'menh', 'Mệnh', 'text', 13, 1),
(7, 1, 'noi_sinh', 'Nơi sinh', 'textarea', 12, 1),
(8, 1, 'gioi_tinh', 'Giới tính', 'radio', 7, 1),
(9, 1, 'chieu_cao', 'Chiều cao (cm)', 'text', 8, 1),
(10, 1, 'can_nang', 'Cân nặng (kg)', 'text', 9, 1),
(11, 1, 'mau_toc', 'Màu tóc', 'text', 10, 1),
(12, 1, 'kieu_toc', 'Kiểu tóc', 'text', 11, 1),
(13, 1, 'tien_su_benh', 'Tiền sử bệnh', 'textarea', 12, 1),
(14, 2, 'so_cmnd', 'Số CMND/CCCD', 'text', 0, 1),
(15, 2, 'so_ho_chieu', 'Số hộ chiếu', 'text', 0, 1),
(16, 2, 'dan_toc', 'Dân tộc', 'text', 0, 1),
(17, 2, 'ton_giao', 'Tôn giáo', 'text', 0, 1),
(18, 2, 'quoc_tich', 'Quốc tịch', 'text', 0, 1),
(19, 2, 'dk_ho_khau_thuong_chu', 'Đăng kí hộ khẩu thường trú', 'textarea', 0, 1),
(20, 2, 'noi_o_hien_tai', 'Nơi ở hiện tại', 'textarea', 0, 1),
(22, 3, 'dien_thoai', 'Điện thoại', 'text', 0, 1),
(23, 3, 'email', 'Email', 'text', 0, 1),
(24, 3, 'tk_ngan_hang', 'Tk Ngân hàng', 'text', 0, 1),
(25, 3, 'ma_so_thue', 'Mã số thuế', 'text', 0, 1),
(26, 3, 'tinh_trang_ket_hon', 'Tình trạng kết hôn', 'radio', 0, 1),
(27, 3, 'lan_ket_hon', 'Kết hôn lần thứ mấy', 'text', 0, 1),
(28, 3, 'noi_ket_hon', 'Nơi tổ chức kết hôn', 'select', 0, 1),
(29, 3, 'trinh_do_hoc_van', 'Trình độ học vấn', 'select', 0, 1),
(30, 3, 'don_vi_cong_tac', 'Đơn vị công tác', 'textarea', 0, 1),
(31, 3, 'vi_tri_cong_tac', 'Vị trí công tác', 'text', 0, 1),
(32, 4, 'ten_mon_the_thao', 'Tên môn', 'text', 0, 1),
(33, 4, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(34, 5, 'ten_mon', 'Tên món', 'text', 0, 1),
(35, 5, 'ten_quoc_gia', 'Tên quốc gia', 'text', 0, 1),
(36, 5, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(37, 6, 'ten_bo_mon', 'Tên bộ môn', 'text', 0, 1),
(38, 6, 'ten_tac_pham', 'Tên tác phẩm', 'text', 0, 1),
(39, 6, 'ten_tac_gia', 'Tên tác giả', 'text', 0, 1),
(40, 6, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'te', 0, 1),
(41, 7, 'the_loai', 'Thể loại', 'text', 0, 1),
(42, 7, 'tac_gia', 'Tác giả', 'text', 0, 1),
(43, 7, 'tac_pham', 'Tác phẩm', 'text', 0, 1),
(44, 7, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(45, 8, 'hang_xe', 'Hãng xe', 'text', 0, 1),
(46, 8, 'dong_xe', 'Dòng xe', 'text', 0, 1),
(47, 8, 'mau_sac', 'Màu sắc', 'text', 0, 1),
(48, 9, 'hang', 'Hãng', 'text', 0, 1),
(49, 9, 'model', 'Model', 'text', 0, 1),
(50, 9, 'mau_sac', 'Màu sắc', 'text', 0, 1),
(51, 10, 'thuong_hieu_thoi_trang', 'Thương hiệu thời trang', 'text', 0, 1),
(52, 10, 'mau_chu_dao', 'Màu chủ đạo', 'text', 0, 1),
(53, 10, 'loai_trang_phuc_yeu_thich', 'Loại trang phục yêu thích', 'text', 0, 1),
(54, 11, 'thuong_hieu', 'Thương hiệu', 'text', 0, 1),
(55, 11, 'size', 'Size', 'text', 0, 1),
(56, 11, 'mau_sac', 'Màu sắc', 'text', 0, 1),
(57, 11, 'loai_giay', 'Loại giày', 'text', 0, 1),
(58, 12, 'thuong_hieu', 'Thương hiệu', 'text', 0, 1),
(59, 12, 'mui_vi', 'Mùi vị', 'text', 0, 1),
(60, 13, 'thich_uong_gi', 'Thích uống gì', 'text', 0, 1),
(61, 13, 'hang_nao', 'Hãng', 'text', 0, 1),
(62, 13, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(63, 14, 'thich_hat_hay_khong', 'Thích hát hay không', 'radio', 0, 1),
(64, 14, 'dong_nhac', 'Dòng nhạc yêu thích', 'text', 0, 1),
(65, 14, 'bai_hat_yeu_thich', 'Bài hát yêu thích', 'text', 0, 1),
(66, 15, 'hang', 'Hãng', 'text', 0, 1),
(67, 15, 'model', 'Model', 'text', 0, 1),
(68, 15, 'mau_sac', 'Màu sắc', 'text', 0, 1),
(69, 16, 'hang', 'Hãng', 'text', 0, 1),
(70, 16, 'model', 'Model', 'text', 0, 1),
(71, 16, 'mau_sac', 'Màu sắc', 'text', 0, 1),
(72, 17, 'ca_sy_yeu_thich', 'Ca sĩ yêu thích', 'text', 0, 1),
(73, 17, 'the_loai', 'Thể loại', 'text', 0, 1),
(74, 17, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(75, 18, 'loai_hinh_du_lich', 'Loại hình du lich', 'text', 0, 1),
(76, 18, 'dac_diem_yeu_thich', 'Đặc điểm yêu thích', 'text', 0, 1),
(77, 18, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(78, 19, 'ho_ten', 'Họ tên', 'text', 1, 1),
(79, 19, 'bi_danh', 'Bí danh', 'text', 2, 1),
(80, 19, 'hinh_anh', 'Hình ảnh đại diện', 'file', 3, 1),
(81, 19, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(82, 19, 'ngay_mat', 'Ngày mất', 'text', 5, 1),
(83, 19, 'menh', 'Mệnh', 'text', 9, 1),
(84, 19, 'gioi_tinh', 'Giới tính', 'radio', 6, 1),
(85, 19, 'noi_sinh', 'Nơi sinh', 'textarea', 7, 1),
(86, 19, 'tien_su_benh', 'Tiền sử bệnh', 'textarea', 8, 1),
(87, 20, 'dien_thoai', 'Điện thoại', 'text', 1, 1),
(88, 20, 'noi_o_hien_tai', 'Nơi ở hiện tại', 'textarea', 3, 1),
(89, 20, 'tinh_trang_ket_hon', 'Tình trạng hôn nhân', 'radio', 2, 1),
(90, 20, 'don_vi_cong_tac', 'Đơn vị công tác', 'textarea', 4, 1),
(91, 20, 'vi_tri_cong_tac', 'Vị trí công tác', 'textarea', 5, 1),
(92, 20, 'so_thich_dac_biet', 'Sở thích đặc biệt', 'textarea', 6, 1),
(93, 20, 'quan_he', 'Quan hệ với khách hàng', 'hidden', 0, 1),
(94, 21, 'from_year', 'Từ năm', 'select', 0, 1),
(95, 21, 'to_year', 'Đến năm', 'select', 0, 1),
(96, 21, 'cap_hoc', 'Cấp học', 'select', 0, 1),
(97, 21, 'truong_hoc', 'Trường học', 'text', 0, 1),
(98, 21, 'quoc_gia', 'Quốc gia', 'text', 0, 1),
(99, 21, 'chuyen_nganh', 'Chuyên ngành', 'text', 0, 1),
(100, 22, 'from_year', 'Từ năm', 'select', 0, 1),
(101, 22, 'to_year', 'Đến năm', 'select', 0, 1),
(102, 22, 'vi_tri_cong_tac', 'Vị trí công tác', 'text', 0, 1),
(103, 22, 'don_vi_cong_tac', 'Đơn vị công tác', 'textarea', 0, 1),
(104, 22, 'khen_thuong', 'Khen thưởng', 'text', 0, 1),
(105, 22, 'ky_luat', 'Kỷ luật', 'text', 0, 1),
(106, 22, 'dia_chi', 'Địa chỉ', 'textarea', 0, 1),
(107, 23, 'cap_do_quan_he', 'Cấp độ quan hệ', 'select', 0, 1),
(108, 23, 'hinh_thuc_quan_he', 'Hình thức quan hệ', 'select', 0, 1),
(109, 23, 'dau_moi', 'Đầu mối', 'text', 0, 1),
(110, 23, 'loai_quan_he', 'Loại quan hệ', 'text', 0, 1),
(111, 23, 'so_dien_thoai', 'Số điện thoại', 'text', 0, 1),
(112, 23, 'co_quan', 'Cơ quan', 'text', 0, 1),
(113, 23, 'dia_chi', 'Địa chỉ', 'text', 0, 1),
(114, 24, 'ten_doanh_nghiep', 'Tên doanh nghiệp', 'text', 1, 1),
(115, 24, 'loai_hinh_kinh_doanh', 'Loại hình kinh doanh', 'textarea', 2, 1),
(116, 24, 'cap_do', 'Cấp độ', 'select', 3, 1),
(117, 24, 'ngay_thanh_lap', 'Ngày thành lập', 'text', 4, 1),
(118, 24, 'dia_chi', 'Địa chỉ', 'textarea', 5, 1),
(119, 24, 'giay_phep', 'Giấy phép', 'text', 6, 1),
(120, 24, 'so_dien_thoai', 'Số điện thoại', 'text', 7, 1),
(121, 24, 'ma_so_thue', 'Mã số thuế', 'text', 8, 1),
(122, 24, 'tai_khoan_ngan_hang', 'Tài khoản ngân hàng', 'text', 9, 1),
(123, 24, 'mo_hinh_to_chuc', 'Mô hình tổ chức', 'file', 10, 1),
(124, 25, 'doanh_so', 'Doanh số', 'text', 1, 1),
(125, 25, 'chi_phi_hoat_dong_mua_sam', 'Chi phí hoạt động mua sắm', 'text', 2, 1),
(126, 25, 'thu_hang', 'Thứ hạng trong nghành/quốc gia', 'text', 3, 1),
(127, 26, 'ho_ten', 'Họ tên', 'text', 1, 1),
(128, 26, 'bi_danh', 'Bí danh', 'text', 2, 1),
(129, 26, 'hinh_anh', 'Hình ảnh', 'file', 3, 1),
(130, 26, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(131, 26, 'menh', 'Mệnh', 'text', 5, 1),
(132, 26, 'noi_sinh', 'Nơi sinh', 'textarea', 6, 1),
(133, 26, 'gioi_tinh', 'Giới tính', 'radio', 7, 1),
(134, 26, 'tien_su_benh', 'Tiền sử bệnh', 'textarea', 8, 1),
(135, 27, 'chuc_danh', 'Chức danh', 'text', 1, 1),
(136, 27, 'so_dien_thoai', 'Số điện thoại', 'text', 2, 1),
(137, 27, 'noi_o_hien_tai', 'Nơi ở hiện tại', 'textarea', 3, 1),
(138, 27, 'tinh_trang_ket_hon', 'Tình trạng hôn nhân', 'radio', 4, 1),
(139, 27, 'so_thich_dac_biet', 'Sở thích đặc biệt', 'text', 5, 1),
(140, 31, 'ten_doanh_nghiep', 'Tên doanh nghiệp', 'text', 1, 1),
(141, 31, 'loai_hinh_kinh_doanh', 'Loại hình kinh doanh', 'text', 2, 1),
(142, 31, 'cap_do', 'Cấp độ', 'select', 0, 1),
(143, 31, 'ngay_thanh_lap', 'Ngày thành lập', 'text', 0, 1),
(144, 31, 'dia_chi', 'Địa chỉ', 'textarea', 5, 1),
(145, 31, 'giay_phep', 'Giấy phép', 'text', 6, 1),
(146, 31, 'so_dien_thoai', 'Số điện thoại', 'text', 7, 1),
(147, 31, 'ma_so_thue', 'Mã số thuế', 'text', 8, 1),
(148, 31, 'tai_khoan_ngan_hang', 'Tài khoản ngân hàng', 'text', 9, 1),
(149, 31, 'mo_hinh_to_chuc', 'Mô hình tổ chức', 'file', 10, 1),
(150, 32, 'ho_ten', 'Họ tên', 'text', 1, 1),
(151, 32, 'bi_danh', 'Bí danh', 'text', 2, 1),
(152, 32, 'hinh_anh_dai_dien', 'Hình ảnh đại diện', 'file', 3, 1),
(153, 32, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(154, 32, 'menh', 'Mệnh', 'text', 5, 1),
(155, 32, 'gioi_tinh', 'Giới tính', 'radio', 6, 1),
(156, 32, 'tinh_trang_ket_hon', 'Tình trạng hôn nhân', 'radio', 7, 1),
(157, 32, 'so_thich_dac_biet', 'Sở thích đặc biệt', 'textarea', 8, 1),
(158, 33, 'ten_to_chuc', 'Tên tổ chức', 'text', 1, 1),
(159, 33, 'loai_hinh_hoat_dong', 'Loại hình hoạt động', 'text', 3, 1),
(160, 33, 'cap_do', 'Cấp độ', 'select', 3, 1),
(161, 33, 'ngay_thanh_lap', 'Ngày thành lập', 'text', 4, 1),
(162, 33, 'dia_chi', 'Địa chỉ', 'textarea', 5, 1),
(163, 33, 'so_dien_thoai', 'Số điện thoại', 'text', 6, 1),
(164, 33, 'tai_khoan_ngan_hang', 'Tài khoản ngân hàng', 'text', 7, 1),
(165, 33, 'mo_hinh_to_chuc', 'Mô hình tổ chức', 'file', 8, 1),
(166, 34, 'chi_phi_mua_sam', 'Chi phí mua sắm 3 năm gần nhất', 'text', 1, 1),
(167, 35, 'ho_ten', 'Họ tên', 'text', 1, 1),
(168, 35, 'bi_danh', 'Bí danh', 'text', 2, 1),
(169, 35, 'hinh_anh_dai_dien', 'Hình ảnh đại diện', 'file', 3, 1),
(170, 35, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(171, 35, 'menh', 'Mệnh', 'text', 5, 1),
(172, 35, 'noi_sinh', 'Nơi sinh', 'textarea', 6, 1),
(173, 35, 'gioi_tinh', 'Giới tính', 'radio', 7, 1),
(174, 35, 'tien_su_benh', 'Tiền sử bệnh', 'textarea', 8, 1),
(175, 36, 'chuc_danh', 'Chức danh', 'text', 1, 1),
(176, 36, 'so_dien_thoai', 'Số điện thoại', 'text', 2, 1),
(177, 36, 'noi_o_hien_tai', 'Nơi ở hiện tại', 'textarea', 3, 1),
(178, 36, 'tinh_trang_hon_nhan', 'Tình trạng hôn nhân', 'radio', 4, 1),
(179, 36, 'so_thich_dac_biet', 'Sở thích đặc biệt', 'textarea', 5, 1),
(180, 37, 'ten_to_chuc', 'Tên tổ chức', 'text', 1, 1),
(181, 37, 'loai_hinh_kinh_doanh', 'Loại hình kinh doanh', 'text', 2, 1),
(182, 37, 'cap_do', 'Cấp độ', 'select', 3, 1),
(183, 37, 'ngay_thanh_lap', 'Ngày thành lập', 'text', 4, 1),
(184, 37, 'dia_chi', 'Địa chỉ', 'textarea', 5, 1),
(185, 37, 'so_dien_thoai', 'Số điện thoại', 'text', 6, 1),
(186, 37, 'tai_khoan_ngan_hang', 'Tài khoản ngân hàng', 'text', 7, 1),
(187, 37, 'mo_hinh_to_chuc', 'Mô hình tổ chức', 'file', 8, 1),
(188, 38, 'ho_ten', 'Họ tên', 'text', 1, 1),
(189, 38, 'bi_danh', 'Bí danh', 'text', 2, 1),
(190, 38, 'hinh_anh_dai_dien', 'Hình ảnh đại diện', 'file', 3, 1),
(191, 38, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(192, 38, 'menh', 'Mệnh', 'text', 5, 1),
(193, 38, 'gioi_tinh', 'Giới tính ', 'radio', 6, 1),
(194, 38, 'tinh_trang_hon_nhan', 'Tình trạng hôn nhân', 'radio', 7, 1),
(195, 38, 'so_thich_dac_biet', 'Sở thích đặc biệt', 'textarea', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_meet`
--

CREATE TABLE `tbl_meet` (
  `id` int(11) NOT NULL,
  `mem_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `content` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT '0',
  `datetime` datetime NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` text NOT NULL,
  `result` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `next_time` datetime NOT NULL,
  `next_content` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_meet`
--

INSERT INTO `tbl_meet` (`id`, `mem_id`, `customer_id`, `content`, `status`, `datetime`, `type`, `address`, `image`, `result`, `next_time`, `next_content`, `note`) VALUES
(92, 2, 28, 'Đi đám cưới1', 'st_faile', '2018-04-10 00:00:00', 'tang_qua', 'Hà Nam', 'uploads/images/thuytay.png', 'Quá tốt1', '2019-01-22 00:00:00', 'Trao đổi văn bản1', 'xxx');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_level`
--

CREATE TABLE `tbl_member_level` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `birthday` date NOT NULL,
  `identify` int(11) NOT NULL DEFAULT '0',
  `position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permistion` tinyint(2) NOT NULL,
  `cdate` datetime NOT NULL,
  `mdate` date NOT NULL,
  `isactive` int(11) DEFAULT '1',
  `avatar` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 COLLATE=utf8_unicode_ci DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_member_level`
--

INSERT INTO `tbl_member_level` (`username`, `password`, `id`, `gender`, `phone`, `fullname`, `email`, `birthday`, `identify`, `position`, `permistion`, `cdate`, `mdate`, `isactive`, `avatar`) VALUES
('administrator', 'd2bb9c3211ea6baed657a6c23c9c2faa', 2, '0', '0903456789', 'Administrator', 'admin@viettel.com.vn', '1991-03-29', 1023456789, 'Quản trị viên', 1, '2016-05-23 00:00:00', '2018-04-11', 1, NULL),
('chuotbeo', 'd2bb9c3211ea6baed657a6c23c9c2faa', 53, '1', '0988777666', 'Mai Minh Anh', 'chuot@gmail.com', '2018-04-11', 98876655, '', 2, '2018-04-11 22:29:15', '2018-04-11', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_note`
--

CREATE TABLE `tbl_note` (
  `id` int(11) NOT NULL,
  `mem_id` int(10) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_note`
--

INSERT INTO `tbl_note` (`id`, `mem_id`, `customer_id`, `content`, `cdate`) VALUES
(17, 2, 25, 'Đi du lich', '2018-04-11 11:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_option_field`
--

CREATE TABLE `tbl_option_field` (
  `id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_option_field`
--

INSERT INTO `tbl_option_field` (`id`, `field_id`, `name`, `value`) VALUES
(1, 28, 'Nhà riêng', 'nha_rieng'),
(2, 28, 'Nhà hàng', 'nha_hang'),
(3, 29, 'Cao đẳng', 'cao_dang'),
(4, 29, 'Đại học', 'dai_hoc'),
(5, 29, 'Thạc sĩ', 'thac_si'),
(6, 29, 'Tiến sĩ', 'tien_si'),
(7, 26, 'Đã kết hôn', 'da_ket_hon'),
(8, 26, 'Chưa', 'chua_ket_hon'),
(9, 116, 'Tập đoàn', 'tap_doan'),
(10, 116, 'Tổng công ty', 'tong_cong_ty'),
(11, 116, 'Công ty con', 'cong_ty_con'),
(12, 116, 'Chi nhánh', 'chi_nhanh'),
(13, 133, 'Nam', '0'),
(14, 133, 'Nữ', '1'),
(15, 138, 'Kết hôn', 'da_ket_hon'),
(16, 138, 'Chưa', 'chua_ket_hon'),
(17, 155, 'Nam', '0'),
(18, 155, 'Nữ', '1'),
(19, 156, 'Đã kết hôn', 'da_ket_hon'),
(20, 156, 'Chưa', 'chua_ket_hon'),
(21, 142, 'Tập đoàn', 'tap_doan'),
(22, 142, 'Tổng công ty', 'tong_cong_ty'),
(23, 142, 'Công ty con', 'cong_ty_con'),
(24, 142, 'Chi nhánh', 'chi_nhanh'),
(25, 178, 'Đã kết hôn', 'da_ket_hon'),
(26, 178, 'Chưa', 'chua_ket_hon'),
(27, 173, 'Nam', '0'),
(28, 173, 'Nữ', '0'),
(29, 193, 'Đã kết hôn', 'da_ket_hon'),
(30, 193, 'Chưa', 'chua_ket_hon'),
(31, 194, 'Nam', '0'),
(32, 194, 'Nữ', '1'),
(33, 160, 'Chính phủ', 'chinh_phu'),
(34, 160, 'Bộ', 'bo'),
(35, 160, 'Cục', 'cuc'),
(36, 160, 'Sở', 'so'),
(37, 182, 'Chính phủ', 'chinh_phu'),
(38, 182, 'Bộ', 'bo'),
(39, 182, 'Cục', 'cuc'),
(40, 182, 'Sở', 'so');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_relationship`
--

CREATE TABLE `tbl_relationship` (
  `id` int(10) NOT NULL,
  `relationship` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_relationship`
--

INSERT INTO `tbl_relationship` (`id`, `relationship`) VALUES
(1, 'Bố đẻ'),
(2, 'Mẹ đẻ'),
(3, 'Bố vợ'),
(4, 'Mẹ vợ'),
(5, 'Con đẻ'),
(6, 'Con nuôi'),
(7, 'Anh trai'),
(8, 'Em trai'),
(9, 'Chị gái'),
(10, 'Em gái'),
(11, 'Vợ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

CREATE TABLE `tbl_schedule` (
  `id` int(11) NOT NULL,
  `mem_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `event_subject` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `event_description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `all_day` tinyint(1) NOT NULL,
  `event_start` datetime NOT NULL,
  `event_end` datetime NOT NULL,
  `cdate` datetime NOT NULL,
  `mdate` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `service_name` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `service_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_schedule`
--

INSERT INTO `tbl_schedule` (`id`, `mem_id`, `user_id`, `service_id`, `event_subject`, `event_description`, `all_day`, `event_start`, `event_end`, `cdate`, `mdate`, `status`, `service_name`, `service_price`) VALUES
(83, 2, 54, 0, 'Chị Hà hẹn lịch', 'Okie em nhé', 0, '2017-03-11 07:00:00', '2017-03-11 08:00:00', '2017-03-11 00:07:00', '2017-03-11 00:09:41', 3, 'Trị nám da mặt', 1700000),
(84, 2, 54, 0, 'xxxx', 'xxxxxx', 0, '2017-03-11 08:30:00', '2017-03-11 09:00:00', '2017-03-11 00:10:05', '2017-03-11 00:10:16', 3, 'xxxx', 890000),
(85, 2, 54, 0, 'DDD', 'Okie mem', 0, '2017-03-12 00:00:00', '2017-03-12 05:00:00', '2017-03-11 00:12:26', '2017-03-11 00:12:26', 3, 'Trắng mặt', 2000000),
(86, 2, 54, 0, 'DDD', 'Okie mem', 0, '2017-03-12 00:00:00', '2017-03-12 05:00:00', '2017-03-11 00:12:26', '2017-03-11 00:12:26', 3, 'Trắng mặt', 2000000),
(87, 2, 54, 0, 'xxxx', 'xcxcxc', 0, '2017-03-12 00:00:00', '2017-03-13 00:00:00', '2017-03-11 00:12:40', '2017-03-11 00:12:40', 3, 'xxxx', 3333),
(88, 51, 60, 0, 'C trang hen lam mặt', '2h chi nhe', 0, '2017-04-02 01:00:00', '2017-04-02 01:30:00', '2017-04-02 00:08:08', '2017-04-02 00:10:17', 3, 'Tri vết nám', 3000000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_category`
--

CREATE TABLE `tbl_sub_category` (
  `id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(50) NOT NULL,
  `cdate` date NOT NULL,
  `isactive` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sub_category`
--

INSERT INTO `tbl_sub_category` (`id`, `cat_id`, `name`, `alias`, `cdate`, `isactive`) VALUES
(1, 1, 'Thông tin gắn định danh cơ thể', 'thong_tin_gan_dinh_danh_co_the', '2018-04-01', 1),
(2, 1, 'Thông tin quản lý cá nhân trong xã hội', 'thong_tin_quan_ly_ca_nhan_trong_xa_hoi', '2018-04-01', 1),
(3, 1, 'Thông tin xã hội hiện tại', 'thong_tin_xa_hoi_hien_tai', '2018-04-01', 1),
(4, 2, 'Thể thao', 'the_thao', '2018-04-01', 1),
(5, 2, 'Ẩm thực', 'am_thuc', '2018-04-01', 1),
(6, 2, 'Nghệ thuật', 'nghe_thuat', '2018-04-01', 1),
(7, 2, 'Sách', 'sach', '2018-04-01', 1),
(8, 2, 'Xe', 'xe', '2018-04-01', 1),
(9, 2, 'Điện thoại', 'dien_thoai', '2018-04-01', 1),
(10, 2, 'Thời trang', 'thoi_trang', '2018-04-01', 1),
(11, 2, 'Giày', 'giay', '2018-04-01', 1),
(12, 2, 'Nước hoa', 'nuoc_hoa', '2018-04-01', 1),
(13, 2, 'Đồ uống', 'do_uong', '2018-04-01', 1),
(14, 2, 'Ca hát', 'ca_hat', '2018-04-01', 1),
(15, 2, 'Kính đeo', 'kinh_deo', '2018-04-01', 1),
(16, 2, 'Đồng hồ', 'dong_ho', '2018-04-01', 1),
(17, 2, 'Âm nhạc', 'am_nhac', '2018-04-01', 1),
(18, 2, 'Du lịch', 'du_lich', '2018-04-01', 1),
(19, 3, 'Thông tin gắn định danh cơ thể', 'thong_tin_gan_dinh_danh_co_the', '2018-04-01', 1),
(20, 3, 'Thông tin khác', 'thong_tin_khac', '2018-04-01', 1),
(21, 4, 'Quá trình học tập', 'qua_trinh_hoc_tap', '2018-04-01', 1),
(22, 5, 'Lý lịch công tác', 'ly_lich_cong_tac', '2018-04-01', 1),
(23, 6, 'Quan hệ xã hội', 'quan_he_xa_hoi', '2018-04-01', 1),
(24, 7, 'Thông tin cơ bản', 'thong_tin_co_ban', '2018-04-01', 1),
(25, 7, 'Thông tin khác', 'thong_tin_khac', '2018-04-01', 1),
(26, 8, 'Thông tin gắn định danh cơ thể', 'thong_tin_gan_dinh_danh_co_the', '2018-04-01', 1),
(27, 8, 'Thông tin khác', 'thong_tin_khac', '2018-04-01', 1),
(31, 9, 'Thông tin định danh gắn với tổ chức', 'thong_tin_dinh_danh_gan_voi_to_chuc', '2018-04-01', 1),
(32, 9, 'Thông tin người đại diện của đối tác', 'thong_tin_nguoi_dai_dien_doi_tac', '2018-04-01', 1),
(33, 10, 'Thông tin cơ bản', 'thong_tin_co_ban', '2018-04-09', 1),
(34, 10, 'Thông tin khác', 'thong_tin_khac', '2018-04-09', 1),
(35, 11, 'Thông tin gán định danh cơ thể', 'thong_tin_gan_dinh_danh_co_the', '2018-04-09', 1),
(36, 11, 'Thông tin khác', 'thong_tin_khac', '2018-04-09', 1),
(37, 12, 'Thông tin định danh gán với tổ chức', 'thong_tin_dinh_danh_gan_to_chu', '2018-04-09', 1),
(38, 12, 'Thông tin người đại diện của đối tác', 'thong_tin_nguoi_dai_dien_cua_doi_tac', '2018-04-09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` int(11) NOT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `avatar` text COLLATE utf8_unicode_ci NOT NULL,
  `cdate` datetime NOT NULL,
  `isactive` tinyint(4) NOT NULL DEFAULT '1',
  `mem_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `fullname`, `gender`, `phone`, `birthday`, `address`, `type`, `avatar`, `cdate`, `isactive`, `mem_id`) VALUES
(60, 'Trần Thu Trang', 'Nam', '01656241161', 0, 'Số 89A Cầu Giấy - Hà Nội', 0, '', '2017-03-21 18:04:38', 1, 51),
(61, 'Trần Thi Loan', 'Nữ', '0985823390', -28800, 'Bắc Ninh', 1, '', '2017-03-21 18:04:38', 1, 51),
(62, 'Hoang xuan vinh', 'Nữ', '0975837250', 1491238800, 'xxx', 0, '', '2017-04-02 23:03:54', 1, 51),
(63, 'xxxx', 'Nữ', 'xxxx', 1509123600, 'xxx', 0, '', '2017-10-28 23:55:00', 1, 56);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_common`
--
ALTER TABLE `tbl_common`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer_detail`
--
ALTER TABLE `tbl_customer_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_field_infomation`
--
ALTER TABLE `tbl_field_infomation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_meet`
--
ALTER TABLE `tbl_meet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_member_level`
--
ALTER TABLE `tbl_member_level`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `11` (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `isactive` (`isactive`);

--
-- Indexes for table `tbl_note`
--
ALTER TABLE `tbl_note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_option_field`
--
ALTER TABLE `tbl_option_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_relationship`
--
ALTER TABLE `tbl_relationship`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_common`
--
ALTER TABLE `tbl_common`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `tbl_customer_detail`
--
ALTER TABLE `tbl_customer_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1765;
--
-- AUTO_INCREMENT for table `tbl_field_infomation`
--
ALTER TABLE `tbl_field_infomation`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;
--
-- AUTO_INCREMENT for table `tbl_meet`
--
ALTER TABLE `tbl_meet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `tbl_member_level`
--
ALTER TABLE `tbl_member_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `tbl_note`
--
ALTER TABLE `tbl_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tbl_option_field`
--
ALTER TABLE `tbl_option_field`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `tbl_relationship`
--
ALTER TABLE `tbl_relationship`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
