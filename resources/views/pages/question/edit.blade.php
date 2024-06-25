@extends('layouts.dashboard')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">{{ $title }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('questions.update', $question->id) }}" method="post">
                            @method('put')
                            @csrf
                            <div class="mb-3">
                                <label>Pertanyaan</label>
                                <input type="text" class="form-control" value="{{ $question->question_text }}"
                                    name="question_text" required>
                            </div>
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h6 class="fw-bold flex-grow-1">Jawaban</h6>
                        <div class="flex-shrink-0">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addAnswer">
                                <i class="fas fa-plus-circle"></i> Tambah Jawaban
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="addAnswer" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Jawaban Baru</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('answers.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                                            <div class="modal-body">
                                                <div>
                                                    <label>Jawaban</label>
                                                    <input id="answer_text" type="hidden" name="answer_text" required>
                                                    <trix-editor input="answer_text"></trix-editor>
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
                    <div class="card-body">
                        @if (count($answers) != 0)
                            @foreach ($answers as $answer)
                                <div class="p-3 border border-warning rounded mb-2 d-flex">
                                    <span class="flex-grow-1">
                                        {!! nl2br($answer->answer_text) !!}
                                    </span>
                                    <form action="{{ route('answers.destroy', $answer->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin dihapus?')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            @endforeach
                            <div class="mt-4">
                                {{ $answers->links() }}
                            </div>
                        @else
                            <p class="text-muted text-center">TIDAK ADA JAWABAN</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
