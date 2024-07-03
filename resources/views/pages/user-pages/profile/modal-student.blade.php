<div class="modal modal-blur fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profil.store') }}" id="main-form" method="POST">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="student_id" id="student_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="number" class="form-control" name="nim" id="nim">
                        <span class="text-danger error_text nim_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <span class="text-danger error_text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                        <span class="text-danger error_text email_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-control text-center" name="gender" id="gender">
                            <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <span class="text-danger error_text gender_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="address" id="address" id="" cols="30" rows="3"></textarea>
                        <span class="text-danger error_text address_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="number" class="form-control" name="phone" id="phone">
                        <span class="text-danger error_text phone_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prodi</label>
                        <select class="form-control text-center" name="study_program_id" id="study_program_id">
                            <option value="" selected disabled>-- Pilih Prodi --</option>
                            @foreach ($study_programs as $study_program)
                                <option value="{{ $study_program->id }}">
                                    {{ $study_program->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error_text study_program_id_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" class="form-control" name="photo" id="photo">
                        <span class="text-danger error_text photo_error"></span>
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
