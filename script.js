function toggleOTPField(type) {
    const otpContainer = document.getElementById(`otp-${type}-container`);
    if (otpContainer.style.display === 'none') {
        otpContainer.style.display = 'block';
    } else {
        otpContainer.style.display = 'none';
    }
}

function verifyOTP(type) {
    const otp = document.getElementById(`otp-${type}`).value;

    fetch('verify_otp.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },

        
        body: `otp_type=${type}&otp_input=${otp}`,
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    });
}

function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
    } else {
        field.type = "password";
    }
}
