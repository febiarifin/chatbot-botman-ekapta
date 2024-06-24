@extends('layouts.dashboard')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">{{ $title }}</h3>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                 <!-- Button trigger modal -->
                 <button type="button" class="btn btn-success btn-round" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-upload"></i>
                    Import Dataset</a>
                </button>

                <a href="{{ route('questions.export') }}" class="btn btn-warning btn-round">
                    <i class="fas fa-download"></i>
                    Export Dataset</a>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Import Dataset</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('questions.import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="alert alert-primary mb-3">
                                        Download template dataset <a href="https://docs.google.com/spreadsheets/d/1x7AGm7quYMxrhDvjHfs3hnO2vhd7eABvQxMSgbR33jQ/edit?usp=sharing" target="_blank">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                    <div>
                                        <label>File (Format: .xlsx, .csv)</label>
                                        <input type="file" class="form-control" name="file" accept=".xlsx, .csv" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#addQuestion">
                    <i class="fas fa-plus-circle"></i>
                    Buat Pertanyaan</a>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addQuestion" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Pertanyaan Baru</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('questions.store') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div>
                                        <label>Pertanyaan</label>
                                        <textarea class="form-control" name="question_text" required placeholder="Tulis pertanyaan..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tabel Data Pertanyaan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pertanyaan</th>
                                        <th>Jawaban</th>
                                        <th>Kutipan</th>
                                        <th>Created At</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Pertanyaan</th>
                                        <th>Jawaban</th>
                                        <th>Kutipan</th>
                                        <th>Created At</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $question->question_text }}</td>
                                            <td>
                                                <span class="badge badge-success">{{ count($question->answers) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">{{ $question->counter }}</span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($question->created_at)->format('d/m/Y H:i A') }}
                                            </td>
                                            <td class="d-flex">
                                                <a href="{{ route('questions.edit', $question->id) }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                &nbsp;
                                                <form action="{{ route('questions.destroy', $question->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin dihapus?')"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
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
