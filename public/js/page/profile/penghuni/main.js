$(document).ready(function ($) {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('.password');

    togglePassword.addEventListener('click', function (e) {
        const type1 = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type1);
        this.classList.toggle('fa-eye-slash');
    });

    const gets = {
        dataProfile: `../dataProfilePenghuni`,
        formProfile: `../user/profile`
    }

    $.ajax({
        url: gets.dataProfile,
        type: "GET",
        cache: false,
        success: function (response) {
            $('#profileID').val(response.data[0].id);
            $('#nameProfile').val(response.data[0].name);
            $('#emailProfile').val(response.data[0].email);
            $('#passwordProfile').val(response.data[0].text);
            $('#nik').val(response.data[0].penghuni.nik_penghuni);
            $('#tempat_lahir').val(response.data[0].penghuni.tempat_lahir);
            $('#tanggal_lahir').val(response.data[0].penghuni.tanggal_lahir);
            $('#no_wa').val(response.data[0].penghuni.telepon_penghuni);
            $('#alamat').val(response.data[0].penghuni.alamat_penghuni);
            $('.profile-username').html(response.data[0].name);
        }
    });

    $('#simpanProfile').html('PERBARUI');

    $('#simpanProfile').click(function (e) {
        e.preventDefault();
        $(this).html('Proses...');
        let profile_id = $('#profileID').val();

        $('#nameProfile').removeClass('is-invalid');
        $('#emailProfile').removeClass('is-invalid');
        $('#passwordProfile').removeClass('is-invalid');

        $.ajax({
            url: gets.formProfile + `/${profile_id}`,
            type: "POST",
            data: $('#FormProfile').serialize(),
            success: function (response) {
                if ($.isEmptyObject(response.errors)) {
                    $('#nameProfile').removeClass('is-invalid');
                    $('#emailProfile').removeClass('is-invalid');
                    $('#passwordProfile').removeClass('is-invalid');

                    $('#profileID').val(response.data.id);
                    $('#nameProfile').val(response.data.name);
                    $('#emailProfile').val(response.data.email);
                    $('#passwordProfile').val(response.data.text);
                    $('.profile-username').html(response.data.name);
                    $('#navUsers').html('Hi, '+response.data.name);

                    showNotif('success', 'topRight', 'Profile', (profile_id ? 'Berhasil diperbarui' : 'Berhasil ditambahkan'));

                    $('#simpanProfile').html('PERBARUI');
                } else {
                    errorMsg(response.errors, 'Form Profile', 'Mohon periksa kembali! Terdapat kolom yang kosong');

                    $('#simpanProfile').html('PERBARUI');
                }
            }
        });
    });
})
