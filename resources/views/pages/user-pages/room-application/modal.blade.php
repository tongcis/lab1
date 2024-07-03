<div class="modal modal-blur fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pengajuan-user.store') }}" id="main-form" method="POST">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ruangan</label>
                        <select class="form-control text-center" name="room_id" id="room_id">
                            <option value="" selected disabled>-- Pilih Ruangan --</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">
                                    {{ $room->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error_text room_id_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Keperluan</label>
                        <select class="form-control text-center" name="type_room_id" id="type_room_id">
                            <option value="" selected disabled>-- Pilih Jenis Keperluan --</option>
                            @foreach ($typeRooms as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error_text type_room_id_error"></span>
                    </div>
                    <div class="mb-3" id="lecturer" style="display: none;">
                        <label class="form-label" id="title-lecturer"></label>
                        <select class="form-control text-center" name="lecturer_id" id="lecturer_id">
                            <option value="" selected disabled>-- Pilih Dosen --</option>
                            @if (auth()->user()->hasRole('Lecturer'))
                                @foreach ($lecturers as $lecturer)
                                    <option value="{{ $lecturer->user_id }}">{{ $lecturer->name }}</option>
                                @endforeach
                                <option value="{{ Auth::user()->lecturer->user_id }}" selected>
                                    {{ Auth::user()->lecturer->name }}
                                </option>
                            @else
                                @foreach ($lecturers as $lecturer)
                                    <option value="{{ $lecturer->user_id }}">{{ $lecturer->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="text-danger error_text lecturer_id_error"></span>
                    </div>
                    <div class="mb-3" id="study" style="display: none;">
                        <label class="form-label">Prodi</label>
                        <select class="form-control text-center" name="study_program" id="study_program">
                            <option value="" selected disabled>-- Pilih Prodi --</option>
                            @foreach ($studyPrograms as $study)
                                <option value="{{ $study->id }}">
                                    {{ $study->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error_text study_program_error"></span>
                    </div>
                    <div class="mb-3" id="course" style="display: none;">
                        <label class="form-label">Mata Kuliah</label>
                        <select class="form-control text-center" name="course_id" id="course_id">
                            <option value="" selected disabled>-- Pilih Mata Kuliah --</option>
                        </select>
                        <span class="text-danger error_text course_id_error"></span>
                    </div>
                    <div class="mb-3" id="activity" style="display: none;">
                        <label class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" name="activity_name" id="activity_name">
                        <span class="text-danger error_text activity_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" name="start_time" id="start_time">
                        <span class="text-danger error_text start_time_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Akhir</label>
                        <input type="time" class="form-control" name="end_time" id="end_time">
                        <span class="text-danger error_text end_time_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M14 4l0 4l-6 0l0 -4" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
