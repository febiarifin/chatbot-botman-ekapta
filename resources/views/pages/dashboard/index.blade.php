@extends('layouts.dashboard')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">{{ $title }}</h3>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="{{ route('questions.index') }}" class="btn btn-primary btn-round"><i class="fas fa-plus-circle"></i>
                    Buat Pertanyaan</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pertanyan</p>
                                    <h4 class="card-title">{{ count($questions) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-comments"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Jawaban</p>
                                    <h4 class="card-title">{{ count($answers) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Kutipan</p>
                                    <h4 class="card-title">{{ $counter }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Statistik Pertanyaan</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 375px">
                            <canvas id="statisticsChart"></canvas>
                        </div>
                        <div id="myChartLegend"></div>
                        @for ($i = 0; $i < count($urls_question); $i++)
                            {{-- <span class="border border-secondary rounded p-1"><a href="{{ $urls_question[$i] }}" target="_blank">{{ $labels_question[$i] }}</a></span> --}}
                            <a href="{{ $urls_question[$i] }}" class="position-relative" target="blank">
                                {{ $labels_question[$i] }}
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $datas_question[$i] }}
                                </span>
                            </a> &nbsp; &nbsp;
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Pertanyaan Masuk Terbaru</div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Pertanyaan</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions_new as $question)
                                        <tr>
                                            <td>{{ $question->question_text }}</td>
                                            <td>{{ \Carbon\Carbon::parse($question->created_at)->format('d/m/Y H:i A') }}
                                            </td>
                                            <td>{{ $question->user_info }}</td>
                                            <td>
                                                <a href="{{ route('questions.edit', $question->id) }}"
                                                    class="btn btn-primary btn-sm"> Buat Jawaban <i
                                                        class="fas fa-arrow-right"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
