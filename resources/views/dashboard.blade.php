@extends('layouts.app')

@section('title', 'Dashboard - Buku Tamu')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
    .badge-type {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
    }
    .badge-orang-tua {
        background-color: #dcfce7;
        color: #166534;
    }
    .badge-instansi {
        background-color: #dbeafe;
        color: #1d4ed8;
    }
    .badge-umum {
        background-color: #fef3c7;
        color: #92400e;
    }
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.875rem;
    }
    .orang-tua-bg { background-color: #10b981; }
    .instansi-bg { background-color: #3b82f6; }
    .umum-bg { background-color: #f59e0b; }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Realtime Notification Toast -->
    <div id="realtime-toast" class="hidden fixed top-4 right-4 z-50 bg-white border border-purple-200 shadow-lg rounded-lg px-5 py-4 flex items-center space-x-3">
        <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
        <div class="text-sm"><span class="font-semibold">Tamu baru</span> baru saja masuk.</div>
        <button id="toast-close" class="ml-2 text-gray-400 hover:text-gray-600">&times;</button>
    </div>

    <audio id="notif-audio">
        <source src="data:audio/mp3;base64,//uQZAAAAAAAAAAAAAAAAAAAAAAAWGluZwAAAA8AAAACAAACcQCA..." type="audio/mp3">
    </audio>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Total Tamu -->
        <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Tamu</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalTamu }}</p>
                </div>
                <div class="bg-purple-500 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Kunjungan -->
        <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Kunjungan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalKunjungan }}</p>
                </div>
                <div class="bg-amber-500 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tamu Orang Tua -->
        <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tamu Orang Tua</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalOrangtua }}</p>
                </div>
                <div class="bg-green-500 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tamu Instansi -->
        <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tamu Instansi</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalInstansi }}</p>
                </div>
                <div class="bg-blue-500 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tamu Umum -->
        <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tamu Umum</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUmum }}</p>
                </div>
                <div class="bg-pink-500 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Distribusi Tipe Tamu -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Tipe Tamu</h3>
        <div class="chart-container">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

  

        <!-- Daftar Tamu Terbaru -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Tamu Terbaru</h3>
               
                    
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-2 font-semibold text-gray-700">NAMA</th>
                            <th class="text-left py-3 px-2 font-semibold text-gray-700">TIPE</th>
                            <th class="text-left py-3 px-2 font-semibold text-gray-700">TANGGAL</th>
                            <th class="text-left py-3 px-2 font-semibold text-gray-700">KEPERLUAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($latestGuests as $guest)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-2">
                                    <div class="flex items-center">
                                        <div class="avatar-circle mr-3
                                            @if($guest->tipe == 'Orang Tua') orang-tua-bg
                                            @elseif($guest->tipe == 'Instansi') instansi-bg
                                            @else umum-bg
                                            @endif
                                        ">
                                           
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $guest->nama }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-2">
                                    <span class="badge-type
                                        @if($guest->tipe == 'Orang Tua') badge-orang-tua
                                        @elseif($guest->tipe == 'Instansi') badge-instansi
                                        @else badge-umum
                                        @endif
                                    ">
                                        {{ $guest->tipe }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 text-gray-700">
                                    {{ \Carbon\Carbon::parse($guest->tanggal)->format('d M Y') }}
                                </td>
                                <td class="py-3 px-2 text-gray-700">
                                    {{ Str::limit($guest->keperluan, 30) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">
                                    Belum ada data tamu
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    // Data dari Laravel
    const chartData = @json($chartData);
    const lineData = @json($dataPerBulan);
    const lineLabels = @json($labelsPerBulan);

    // Pie Chart - Distribusi Tipe Tamu
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: chartData.labels,
            datasets: [{
                data: chartData.data,
                backgroundColor: chartData.colors,
                borderWidth: 2,
                borderColor: '#ffffff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });

    // Line Chart - Kunjungan Per Bulan
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: lineLabels,
            datasets: [{
                label: 'Total Kunjungan',
                data: lineData,
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#8b5cf6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            size: 11
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    });
</script>
<script>
    (function(){
        if (!window.location.pathname.match(/\/?(dashboard)?$/)) return;
        const audio = document.getElementById('notif-audio');
        const toast = document.getElementById('realtime-toast');
        const closeBtn = document.getElementById('toast-close');
        const bell = document.querySelector('.fa-bell');
        let lastId = 0;
        let firstEvent = true;

        function showToast() {
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 5000);
        }

        function ringBell() {
            if (!bell) return;
            bell.classList.add('animate-bounce');
            setTimeout(()=> bell.classList.remove('animate-bounce'), 2000);
        }

        closeBtn?.addEventListener('click', () => toast.classList.add('hidden'));

        const streamUrl = '{{ route('dashboard.stream') }}';
        const es = new EventSource(streamUrl);

        es.addEventListener('guest', function (e) {
            try {
                const data = JSON.parse(e.data);
                const id = data.latest_id ?? 0;
                if (!firstEvent && id > lastId) {
                    audio?.play().catch(()=>{});
                    showToast();
                    ringBell();
                }
                lastId = id;
                firstEvent = false;
            } catch(err) {
                // ignore
            }
        });

        es.onerror = function(){ /* let browser auto-reconnect */ };
    })();
</script>
@endpush