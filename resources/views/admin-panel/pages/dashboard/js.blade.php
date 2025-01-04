@if (auth()->user()->role === 1 || auth()->user()->role === 3)
    <script>
        function formatRupiah(angka, prefix) {
            let number_string = angka.toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        var ctx = document.getElementById("chartTransaksi").getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($bulan),
                datasets: [{
                        label: 'Sudah Lunas',
                        data: @json($dataSudahLunas),
                        borderWidth: 2,
                        backgroundColor: '#006FEB',
                        borderColor: '#006FEB',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    },
                    {
                        label: 'Belum Lunas',
                        data: @json($dataBelumLunas),
                        borderWidth: 2,
                        backgroundColor: '#fc544b',
                        borderColor: '#fc544b',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    }
                ]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += formatRupiah(tooltipItem.yLabel, 'Rp. ');
                            return label;
                        }
                    }
                },
                legend: {
                    display: true
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 100000,
                            callback: function(value, index, values) {
                                return formatRupiah(value, 'Rp. ');
                            }
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            display: true
                        },
                        gridLines: {
                            display: true
                        }
                    }]
                },
            }
        });
    </script>
@elseif (auth()->user()->role === 2)
    <script src="{{ asset('js/page/dashboard/owlCarousel.js') }}"></script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.querySelectorAll('.pay-button').forEach(button => {
            button.onclick = function() {
                const snapToken = this.getAttribute('data-idt');
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        location.reload();
                    },
                    onPending: function(result) {
                        // location.reload();
                    },
                    onError: function(result) {
                        alert("jika terjadi error silahkan hubungi admin kost!");
                        location.reload();
                        // $.ajax({
                        //     url: 'handle-expire',
                        //     method: 'POST',
                        //     data: {
                        //         _token: "{{ csrf_token() }}",
                        //         snap_token: snapToken,
                        //         result: result
                        //     },
                        //     success: function(response) {
                        //         if (response.success) {
                        //             location.reload();
                        //         } else {
                        //             alert(response.message);
                        //         }
                        //     },
                        //     error: function(xhr, status, error) {
                        //         console.error(error);
                        //         alert('Something went wrong. Please try again later.');
                        //     }
                        // });
                    },
                    onClose: function() {
                        // location.reload();
                    }
                });
            };
        });
    </script>
@endif
