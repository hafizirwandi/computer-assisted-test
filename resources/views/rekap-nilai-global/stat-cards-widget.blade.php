@if (isset($widget) && $widget != null)
    <style>
        .stat-card {
            border: none;
            border-radius: 20px;
            color: #fff;
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 1;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 100%);
            z-index: -1;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: -20%;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: -1;
        }

        .stat-card:hover {
            transform: translateY(-6px);
        }

        .stat-card.c-blue {
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
        }

        .stat-card.c-teal {
            background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);
        }

        .stat-card.c-orange {
            background: linear-gradient(135deg, #F97316 0%, #C2410C 100%);
        }

        .stat-card.c-purple {
            background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);
        }

        .stat-card.c-green {
            background: linear-gradient(135deg, #10B981 0%, #047857 100%);
        }

        .stat-card.c-pink {
            background: linear-gradient(135deg, #EC4899 0%, #BE185D 100%);
        }

        .stat-card:hover.c-blue {
            box-shadow: 0 15px 25px -10px rgba(37, 99, 235, 0.5);
        }

        .stat-card:hover.c-teal {
            box-shadow: 0 15px 25px -10px rgba(13, 148, 136, 0.5);
        }

        .stat-card:hover.c-orange {
            box-shadow: 0 15px 25px -10px rgba(234, 88, 12, 0.5);
        }

        .stat-card:hover.c-purple {
            box-shadow: 0 15px 25px -10px rgba(124, 58, 237, 0.5);
        }

        .stat-card:hover.c-green {
            box-shadow: 0 15px 25px -10px rgba(5, 150, 105, 0.5);
        }

        .stat-card:hover.c-pink {
            box-shadow: 0 15px 25px -10px rgba(219, 39, 119, 0.5);
        }

        .stat-icon {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(8deg);
        }

        .stat-icon i {
            font-size: 26px;
            color: #fff;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
        }
    </style>

    <div class="row g-3 mb-4">
        <!-- Siswa -->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card stat-card c-blue">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <div>
                        <p class="mb-1 fw-semibold" style="opacity:.85; font-size:.85rem;">Total Siswa</p>
                        <h3 class="mb-0 fw-bold text-white">{{ number_format($widget['total_siswa']) }}</h3>
                    </div>
                    <div class="stat-icon"><i class="ti ti-users"></i></div>
                </div>
            </div>
        </div>
        <!-- Sekolah -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card stat-card c-teal">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <div>
                        <p class="mb-1 fw-semibold" style="opacity:.85; font-size:.85rem;">Total Sekolah</p>
                        <h3 class="mb-0 fw-bold text-white">{{ number_format($widget['total_sekolah']) }}</h3>
                    </div>
                    <div class="stat-icon"><i class="ti ti-school"></i></div>
                </div>
            </div>
        </div>
        <!-- Ujian -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card stat-card c-orange">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <div>
                        <p class="mb-1 fw-semibold" style="opacity:.85; font-size:.85rem;">Total Ujian</p>
                        <h3 class="mb-0 fw-bold text-white">{{ number_format($widget['total_ujian']) }}</h3>
                    </div>
                    <div class="stat-icon"><i class="ti ti-clipboard-list"></i></div>
                </div>
            </div>
        </div>

        <!-- Rata2 -->
        <div class="col-lg-5 col-md-12">
            <div class="row g-2">
                <div class="col-4">
                    <div class="card stat-card c-green">
                        <div class="card-body d-flex justify-content-between align-items-center p-3">
                            <div>
                                <p class="mb-1 fw-semibold text-truncate"
                                    style="opacity:.85; font-size:.85rem; max-width:80px;">Rata-rata</p>
                                <h4 class="mb-0 fw-bold text-white">{{ $widget['rata_nilai'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card stat-card c-blue">
                        <div class="card-body d-flex justify-content-between align-items-center p-3">
                            <div>
                                <p class="mb-1 fw-semibold text-truncate"
                                    style="opacity:.85; font-size:.85rem; max-width:80px;">Max</p>
                                <h4 class="mb-0 fw-bold text-white">{{ $widget['nilai_tertinggi'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card stat-card c-pink">
                        <div class="card-body d-flex justify-content-between align-items-center p-3">
                            <div>
                                <p class="mb-1 fw-semibold text-truncate"
                                    style="opacity:.85; font-size:.85rem; max-width:80px;">Min</p>
                                <h4 class="mb-0 fw-bold text-white">{{ $widget['nilai_terendah'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
