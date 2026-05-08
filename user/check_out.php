<?php
include "../config.php";
require '../site.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../public/login.php");
    exit;
}

if (!isset($_GET['tour_id']) || !isset($_GET['quantity'])) {
    echo "Thiếu dữ liệu! Vui lòng quay lại trang tour.";
    exit;
}

$tour_id  = $_GET['tour_id'];
$quantity = (int)$_GET['quantity'];

$sql = "SELECT * FROM tb_tours WHERE tour_id = '$tour_id'";
$result = $conn->query($sql);
if($result->num_rows == 0){ echo "Không tìm thấy tour!"; exit; }
$row = $result->fetch_assoc();
$total_price = $row['price'] * $quantity;

// Lấy thông tin user đã đăng nhập
$uid = $_SESSION['user_id'];
$sql_user = "SELECT * FROM tb_accounts WHERE id = '$uid'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();

$booking_success = false;
$pay_done        = '';

if(isset($_POST['confirm'])){
    $tour_id_insert = $_POST['tour_id'];
    $qty_insert     = (int)$_POST['quantity'];
    $payment        = $_POST['payment'];
    $total_insert   = $row['price'] * $qty_insert;
    $pay_done       = $payment;

    $sql_insert = "INSERT INTO tb_bookings (user_id, tour_id, quantity, payment, total_price, created_at)
                   VALUES ('$uid', '$tour_id_insert', '$qty_insert', '$payment', '$total_insert', NOW())";

    if(mysqli_query($conn, $sql_insert)){
        $booking_success = true;

        // Gửi mail cho admin nếu chuyển khoản
        if($payment === 'Chuyển khoản'){
            $admin_email = "l3hnug@gmail.com"; // ← thay email admin thật
            $subject = "=?UTF-8?B?" . base64_encode("💸 Xác nhận chuyển khoản - " . $row['nametour']) . "?=";
            $body  = "Khách hàng : " . $user['fullname'] . "\r\n";
            $body .= "SĐT        : " . $user['phone']    . "\r\n";
            $body .= "Email      : " . $user['email']    . "\r\n\r\n";
            $body .= "Tour       : " . $row['nametour']  . "\r\n";
            $body .= "Số người   : " . $qty_insert        . "\r\n";
            $body .= "Tổng tiền  : " . number_format($total_insert) . " VND\r\n\r\n";
            $body .= "Hình thức  : Chuyển khoản MB Bank\r\n";
            $body .= "STK        : 0795613357 - DOAN LE HUNG\r\n\r\n";
            $body .= "Vui lòng kiểm tra sao kê và xác nhận booking trong hệ thống!";
            $headers  = "From: h2huy25@gmail.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            @mail($admin_email, $subject, $body, $headers);
        }
    }
}

// VietQR URL cho MB Bank
$qr_url = "https://img.vietqr.io/image/MB-0795613357-compact2.png"
        . "?amount=" . $total_price
        . "&addInfo=" . urlencode("DAT TOUR " . strtoupper($row['nametour']))
        . "&accountName=" . urlencode("DOAN LE HUNG");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thanh toán | Travel Gia Lai</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
    --teal:#0c8f8f;
    --teal-d:#097a7a;
    --teal-l:#e0f5f5;
    --teal-ll:#f0fafa;
    --gold:#f4a84a;
    --dark:#152525;
    --mid:#3d5555;
    --muted:#7a9e9e;
    --green:#2db87e;
    --red:#e05252;
    --white:#fff;
    --shadow:0 8px 32px rgba(12,143,143,.16);
    --r:14px;
    --rs:10px;
}
body{font-family:'Be Vietnam Pro',sans-serif;background:linear-gradient(160deg,#daf2f2 0%,#c4e8e8 60%,#d0eddf 100%);min-height:100vh;color:var(--dark)}

/* HEADER */
.header{background:var(--teal);height:58px;display:flex;align-items:center;justify-content:space-between;padding:0 36px;position:sticky;top:0;z-index:100;box-shadow:0 2px 18px rgba(12,143,143,.35)}
.logo{font-family:'Playfair Display',serif;color:#fff;font-size:1.2rem;letter-spacing:.5px;display:flex;align-items:center;gap:8px}
.header nav a{color:rgba(255,255,255,.8);text-decoration:none;margin-left:20px;font-size:.88rem;font-weight:500;transition:color .2s}
.header nav a:hover{color:#fff}

/* HERO */
.hero{background:var(--dark);text-align:center;padding:30px 20px 24px;position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(45deg,transparent,transparent 12px,rgba(12,143,143,.07) 12px,rgba(12,143,143,.07) 24px)}
.hero h1{font-family:'Playfair Display',serif;color:#fff;font-size:1.9rem;position:relative}
.hero p{color:rgba(255,255,255,.55);font-size:.88rem;margin-top:5px;position:relative}

/* STEPS */
.steps-bar{display:flex;justify-content:center;max-width:580px;margin:26px auto 0;padding:0 20px}
.step{flex:1;text-align:center;position:relative;font-size:.76rem;color:var(--muted);font-weight:500}
.step::after{content:'';position:absolute;top:14px;left:50%;right:-50%;height:2px;background:#b8d8d8;z-index:0}
.step:last-child::after{display:none}
.sdot{width:28px;height:28px;border-radius:50%;background:#b8d8d8;color:var(--mid);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;margin:0 auto 5px;position:relative;z-index:1;transition:all .3s}
.step.done .sdot{background:var(--green);color:#fff}
.step.active .sdot{background:var(--teal);color:#fff;box-shadow:0 0 0 4px rgba(12,143,143,.2)}
.step.active{color:var(--teal)}

/* LAYOUT */
.wrap{max-width:1000px;margin:32px auto 64px;padding:0 18px;display:grid;grid-template-columns:1fr 390px;gap:26px;align-items:start}

/* CARD */
.card{background:var(--white);border-radius:var(--r);box-shadow:var(--shadow);overflow:hidden;animation:up .45s ease both}
.card:nth-child(2){animation-delay:.08s}
@keyframes up{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
.ch{background:linear-gradient(135deg,var(--teal),var(--teal-d));color:#fff;padding:16px 22px;display:flex;align-items:center;gap:10px}
.ch .ci{font-size:1.3rem}
.ch h3{font-size:.95rem;font-weight:600;letter-spacing:.2px}
.cb{padding:22px}

/* TOUR CARD */
.thumb{width:100%;height:175px;object-fit:cover;border-radius:var(--rs);margin-bottom:15px}
.tname{font-family:'Playfair Display',serif;font-size:1.2rem;margin-bottom:13px;line-height:1.35}
.irow{display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid #eef4f4;font-size:.88rem}
.irow:last-of-type{border:none}
.irow .lbl{color:var(--muted)}
.irow .val{font-weight:600}
.total-box{background:var(--teal-l);border-radius:var(--rs);padding:14px 16px;margin-top:14px;display:flex;justify-content:space-between;align-items:center}
.total-box .lbl{color:var(--teal-d);font-weight:600;font-size:.92rem}
.total-box .val{color:var(--teal);font-size:1.3rem;font-weight:700;font-family:'Playfair Display',serif}

/* PAY TABS */
.pay-tabs{display:grid;grid-template-columns:1fr 1fr;gap:11px;margin-bottom:22px}
.ptab{border:2px solid #cde8e8;border-radius:var(--rs);padding:15px 10px;cursor:pointer;text-align:center;transition:all .22s;background:var(--white);position:relative;user-select:none}
.ptab input{position:absolute;opacity:0;width:0;height:0}
.ptab .pi{font-size:1.9rem;display:block;margin-bottom:5px}
.ptab .pl{font-size:.82rem;font-weight:600;color:var(--muted)}
.ptab.on{border-color:var(--teal);background:var(--teal-l);box-shadow:0 0 0 3px rgba(12,143,143,.1)}
.ptab.on .pl{color:var(--teal)}
.ptab .badge{position:absolute;top:-8px;right:-8px;width:20px;height:20px;background:var(--teal);color:#fff;border-radius:50%;font-size:.7rem;display:none;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(12,143,143,.4)}
.ptab.on .badge{display:flex}

/* CASH PANEL */
.cash-panel{background:linear-gradient(135deg,#fffbf2,#fff4e0);border:1.5px solid rgba(244,168,74,.3);border-radius:var(--rs);padding:18px;display:none}
.cash-panel.show{display:block;animation:fd .3s ease}
.clist{list-style:none}
.clist li{display:flex;gap:12px;padding:11px 0;border-bottom:1px dashed rgba(244,168,74,.3);align-items:flex-start}
.clist li:last-child{border:none}
.cnum{min-width:30px;height:30px;background:var(--gold);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.82rem;box-shadow:0 3px 8px rgba(244,168,74,.3);flex-shrink:0}
.ctxt strong{font-size:.88rem;display:block;margin-bottom:2px}
.ctxt span{font-size:.8rem;color:var(--muted)}
.addr{background:#fff;border-radius:var(--rs);padding:13px 15px;margin-top:14px;border-left:4px solid var(--gold);font-size:.86rem}
.addr strong{color:var(--dark);font-size:.92rem}
.addr p{color:var(--mid);margin-top:4px;line-height:1.65}

/* QR PANEL */
.qr-panel{background:linear-gradient(135deg,var(--teal-ll),#eaf6f6);border:1.5px solid rgba(12,143,143,.2);border-radius:var(--rs);padding:18px;display:none;text-align:center}
.qr-panel.show{display:block;animation:fd .3s ease}
@keyframes fd{from{opacity:0}to{opacity:1}}

.bank-bar{background:var(--dark);color:#fff;border-radius:var(--rs);padding:13px 16px;display:flex;align-items:center;gap:12px;margin-bottom:18px;text-align:left}
.blogo{background:#fff;color:var(--teal);font-weight:900;font-size:.9rem;padding:6px 10px;border-radius:7px;letter-spacing:1px;min-width:54px;text-align:center}
.bdet .bname{font-size:.72rem;color:rgba(255,255,255,.55)}
.bdet .bstk{font-size:1.2rem;font-weight:700;letter-spacing:2px}
.bdet .bacc{font-size:.78rem;color:var(--gold);margin-top:2px}

.amt-pill{display:inline-block;background:var(--teal);color:#fff;font-weight:700;font-size:1.05rem;padding:7px 22px;border-radius:30px;margin-bottom:14px;font-family:'Playfair Display',serif;box-shadow:0 4px 14px rgba(12,143,143,.3)}

.qrwrap{background:#fff;border-radius:12px;padding:14px;display:inline-block;box-shadow:0 4px 20px rgba(12,143,143,.15);margin-bottom:12px;position:relative}
.qrwrap img{width:190px;height:190px;object-fit:contain;display:block}
.qrbadge{position:absolute;bottom:-10px;left:50%;transform:translateX(-50%);background:var(--teal);color:#fff;font-size:.7rem;font-weight:600;padding:3px 12px;border-radius:20px;white-space:nowrap;box-shadow:0 2px 8px rgba(12,143,143,.3)}

.qrnote{font-size:.81rem;color:var(--mid);margin:18px 0 12px;line-height:1.65}
.qrnote strong{color:var(--teal)}

.copy-btn{background:none;border:1.5px solid var(--teal);color:var(--teal);font-size:.78rem;padding:5px 14px;border-radius:20px;cursor:pointer;font-family:inherit;transition:all .2s;display:inline-flex;align-items:center;gap:5px;margin-top:4px}
.copy-btn:hover{background:var(--teal);color:#fff}

.tsteps{list-style:none;text-align:left;margin-top:16px}
.tsteps li{display:flex;gap:10px;align-items:flex-start;padding:9px 0;border-bottom:1px dashed rgba(12,143,143,.12);font-size:.84rem;color:var(--mid)}
.tsteps li:last-child{border:none}
.tsteps .ti{min-width:22px;font-size:1rem}

/* CONFIRM BTN */
.btn-confirm{width:100%;background:linear-gradient(135deg,var(--teal),var(--teal-d));color:#fff;border:none;padding:15px;border-radius:var(--rs);font-family:'Be Vietnam Pro',sans-serif;font-size:.97rem;font-weight:700;cursor:pointer;margin-top:18px;letter-spacing:.4px;box-shadow:0 6px 20px rgba(12,143,143,.35);transition:all .22s;display:flex;align-items:center;justify-content:center;gap:9px}
.btn-confirm:hover{background:linear-gradient(135deg,var(--teal-d),#065f5f);transform:translateY(-2px);box-shadow:0 10px 28px rgba(12,143,143,.4)}
.btn-confirm:active{transform:translateY(0)}
.secure{text-align:center;font-size:.76rem;color:#99bebe;margin-top:10px;display:flex;align-items:center;justify-content:center;gap:5px}

/* SUCCESS */
.soverlay{position:fixed;inset:0;background:rgba(12,143,143,.88);display:flex;align-items:center;justify-content:center;z-index:999;animation:fd .4s ease;padding:20px}
.sbox{background:#fff;border-radius:22px;padding:44px 36px;text-align:center;max-width:400px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.18);animation:pop .45s cubic-bezier(.34,1.56,.64,1) both}
@keyframes pop{from{transform:scale(.7);opacity:0}to{transform:scale(1);opacity:1}}
.sicon{width:76px;height:76px;background:linear-gradient(135deg,var(--teal),var(--green));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:2.1rem;box-shadow:0 10px 30px rgba(12,143,143,.3)}
.sbox h2{font-family:'Playfair Display',serif;font-size:1.55rem;color:var(--dark);margin-bottom:9px}
.sbox p{color:var(--mid);font-size:.88rem;line-height:1.7}
.sbox .snote{background:var(--teal-l);border-radius:var(--rs);padding:12px 15px;margin:14px 0;font-size:.84rem;color:var(--teal-d);border-left:4px solid var(--teal);text-align:left}
.sbox .scode{font-size:.76rem;color:#aac8c8;margin-top:6px}
.btn-home{display:inline-block;margin-top:16px;background:var(--teal);color:#fff;padding:11px 30px;border-radius:30px;text-decoration:none;font-weight:600;font-size:.88rem;box-shadow:0 6px 20px rgba(12,143,143,.3);transition:all .2s}
.btn-home:hover{background:var(--teal-d);transform:translateY(-2px)}

@media(max-width:700px){.wrap{grid-template-columns:1fr}.hero h1{font-size:1.45rem}.header{padding:0 14px}}
</style>
</head>
<body>

<div class="header">
    <div class="logo">✈ Travel Gia Lai</div>
    <nav>
        <a href="../index.php">Trang chủ</a>
        <a href="tours.php">Tour</a>
    </nav>
</div>

<div class="hero">
    <h1>Xác nhận đặt tour</h1>
    <p>Chỉ một bước nữa để bắt đầu hành trình 🌿</p>
</div>

<div class="steps-bar">
    <div class="step done"><div class="sdot">✓</div><span>Chọn tour</span></div>
    <div class="step active"><div class="sdot">2</div><span>Thanh toán</span></div>
    <div class="step"><div class="sdot">3</div><span>Hoàn tất</span></div>
</div>

<div class="wrap">

    <!-- TOUR INFO -->
    <div class="card">
        <div class="ch"><span class="ci">🗺️</span><h3>Thông tin tour</h3></div>
        <div class="cb">
            <img class="thumb" src="../data/image/<?php echo $row['image']; ?>" alt="<?php echo $row['nametour']; ?>">
            <div class="tname"><?php echo $row['nametour']; ?></div>

            <div class="irow"><span class="lbl">📍 Địa điểm</span><span class="val"><?php echo $row['location']; ?></span></div>
            <div class="irow"><span class="lbl">⏱ Thời gian</span><span class="val"><?php echo $row['duration']; ?></span></div>
            <div class="irow"><span class="lbl">👤 Khách hàng</span><span class="val"><?php echo $user['fullname']; ?></span></div>
            <div class="irow"><span class="lbl">📞 SĐT</span><span class="val"><?php echo $user['phone']; ?></span></div>
            <div class="irow"><span class="lbl">🧑‍🤝‍🧑 Số người</span><span class="val"><?php echo $quantity; ?> người</span></div>
            <div class="irow"><span class="lbl">💵 Đơn giá</span><span class="val"><?php echo number_format($row['price']); ?> VNĐ</span></div>

            <div class="total-box">
                <span class="lbl">💰 Tổng thanh toán</span>
                <span class="val"><?php echo number_format($total_price); ?> VNĐ</span>
            </div>
        </div>
    </div>

    <!-- PAYMENT -->
    <div class="card">
        <div class="ch"><span class="ci">💳</span><h3>Phương thức thanh toán</h3></div>
        <div class="cb">

            <form method="POST" id="checkoutForm">
                <input type="hidden" name="tour_id"  value="<?php echo $tour_id; ?>">
                <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                <input type="hidden" name="payment"  id="payHidden" value="Tiền mặt">

                <div class="pay-tabs">
                    <label class="ptab on" id="tabCash">
                        <input type="radio" name="_p" value="cash" checked>
                        <span class="badge">✓</span>
                        <span class="pi">💵</span>
                        <span class="pl">Tiền mặt</span>
                    </label>
                    <label class="ptab" id="tabBank">
                        <input type="radio" name="_p" value="bank">
                        <span class="badge">✓</span>
                        <span class="pi">📱</span>
                        <span class="pl">Chuyển khoản</span>
                    </label>
                </div>

                <!-- CASH -->
                <div class="cash-panel show" id="cashPanel">
                    <ul class="clist">
                        <li>
                            <div class="cnum">1</div>
                            <div class="ctxt">
                                <strong>Xác nhận đặt tour</strong>
                                <span>Bấm "Xác nhận" để ghi nhận booking của bạn</span>
                            </div>
                        </li>
                        <li>
                            <div class="cnum">2</div>
                            <div class="ctxt">
                                <strong>Nhận cuộc gọi xác nhận</strong>
                                <span>Đội ngũ sẽ liên hệ qua SĐT trong vòng 30 phút</span>
                            </div>
                        </li>
                        <li>
                            <div class="cnum">3</div>
                            <div class="ctxt">
                                <strong>Thanh toán tại văn phòng / điểm đón</strong>
                                <span>Mang tiền mặt đúng số tiền khi đến gặp hướng dẫn viên</span>
                            </div>
                        </li>
                    </ul>
                    <div class="addr">
                        <strong>🏢 Văn phòng Travel Gia Lai</strong>
                        <p>01 Phù Đổng Thiên Vương, TP. Pleiku, Gia Lai<br>
                           📞 0795 613 357 &nbsp;·&nbsp; 🕗 07:30 – 17:30 hàng ngày</p>
                    </div>
                </div>

                <!-- BANK / QR -->
                <div class="qr-panel" id="bankPanel">
                    <div class="bank-bar">
                        <div class="blogo">MB</div>
                        <div class="bdet">
                            <div class="bname">MB Bank — Ngân hàng Quân đội</div>
                            <div class="bstk">0795 613 357</div>
                            <div class="bacc">ĐOÀN LÊ HƯNG</div>
                        </div>
                    </div>

                    <div class="amt-pill"><?php echo number_format($total_price); ?> VNĐ</div>

                    <br>
                    <div class="qrwrap">
                        <img src="<?php echo $qr_url; ?>" alt="QR"
                             onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=190x190&data=MBBank+0795613357+<?php echo $total_price; ?>'">
                        <div class="qrbadge">VietQR · MB Bank</div>
                    </div>

                    <div class="qrnote">
                        📝 Nội dung chuyển khoản:<br>
                        <strong>DAT TOUR <?php echo strtoupper($row['nametour']); ?></strong><br>
                        <span style="font-size:.76rem;color:var(--muted)">(Giữ đúng nội dung để admin xác nhận nhanh nhất)</span>
                    </div>

                    <button type="button" class="copy-btn" onclick="copySTK()">📋 Sao chép số TK: 0795613357</button>

                    <ul class="tsteps">
                        <li><span class="ti">1️⃣</span>Mở app ngân hàng → quét QR hoặc chuyển khoản thủ công theo số TK trên</li>
                        <li><span class="ti">2️⃣</span>Điền đúng số tiền <strong><?php echo number_format($total_price); ?> VNĐ</strong> và nội dung</li>
                        <li><span class="ti">3️⃣</span>Bấm "Xác nhận" → admin nhận email và duyệt trong ~1 giờ</li>
                        <li><span class="ti">📧</span>Thông báo xác nhận gửi qua SĐT / email của bạn</li>
                    </ul>
                </div>

                <button type="submit" name="confirm" class="btn-confirm">
                    🎯 &nbsp;Xác nhận đặt tour
                </button>
                <div class="secure">🔒 Thông tin được bảo mật &amp; mã hoá an toàn</div>
            </form>
        </div>
    </div>

</div><!-- end .wrap -->

<?php if($booking_success): ?>
<div class="soverlay" id="so">
    <div class="sbox">
        <div class="sicon">🎉</div>
        <h2>Đặt tour thành công!</h2>
        <p>Cảm ơn <strong><?php echo $user['fullname']; ?></strong> đã tin tưởng Travel Gia Lai.</p>

        <?php if($pay_done === 'Chuyển khoản'): ?>
        <div class="snote">
            📧 Yêu cầu đã gửi tới Admin.<br>
            Tour sẽ được duyệt trong <strong>~1 giờ</strong> sau khi xác nhận thanh toán.
        </div>
        <?php else: ?>
        <div class="snote">
            💵 Vui lòng thanh toán tại văn phòng hoặc điểm đón.<br>
            Đội ngũ sẽ gọi xác nhận trong <strong>30 phút</strong>.
        </div>
        <?php endif; ?>

        <div class="scode">Mã đặt tour: #TGL<?php echo date('YmdHis'); ?></div>
        <a href="tours.php" class="btn-home">← Về trang Tour</a>
    </div>
</div>
<?php endif; ?>

<script>
const tabCash  = document.getElementById('tabCash');
const tabBank  = document.getElementById('tabBank');
const cashPanel = document.getElementById('cashPanel');
const bankPanel = document.getElementById('bankPanel');
const payHidden = document.getElementById('payHidden');

tabCash.addEventListener('click', () => {
    tabCash.classList.add('on'); tabBank.classList.remove('on');
    cashPanel.classList.add('show'); bankPanel.classList.remove('show');
    payHidden.value = 'Tiền mặt';
});
tabBank.addEventListener('click', () => {
    tabBank.classList.add('on'); tabCash.classList.remove('on');
    bankPanel.classList.add('show'); cashPanel.classList.remove('show');
    payHidden.value = 'Chuyển khoản';
});

function copySTK() {
    navigator.clipboard.writeText('0795613357').then(() => {
        const b = document.querySelector('.copy-btn');
        b.textContent = '✅ Đã sao chép!';
        setTimeout(() => b.textContent = '📋 Sao chép số TK: 0795613357', 2000);
    });
}

// Click ngoài overlay để về
const so = document.getElementById('so');
if(so) so.addEventListener('click', e => { if(e.target===so) window.location='tours.php'; });
</script>

</body>
</html>