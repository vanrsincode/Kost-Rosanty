const showNotif = (type = 'info', position = 'topRight', title = '', message) => {
     iziToast[type]({ position, title, message });
};