<div class="modal modal-blur fade" id="modal-detail-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-detail"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table>
                            <tr>
                                <td><strong>Pelapor</strong></td>
                                <td> : </td>
                                <td>
                                    <span id="reporter_complaint"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal</strong></td>
                                <td> : </td>
                                <td>
                                    <span id="date_complaint"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ruangan</strong></td>
                                <td> : </td>
                                <td>
                                    <span id="room_complaint"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Inventaris</strong></td>
                                <td> : </td>
                                <td>
                                    <span id="inventory_complaint"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah</strong></td>
                                <td> : </td>
                                <td>
                                    <span id="quantity_complaint"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Keterangan</strong></td>
                                <td> : </td>
                                <td>
                                    <span id="description_complaint"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td> : </td>
                                <td>
                                    <span id="status_complaint"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>PIC</strong></td>
                                <td> : </td>
                                <td>
                                    <span id="user_complaint"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Tindak Lanjut</strong></td>
                                <td> : </td>
                                <td>
                                    <span id="follow_up_date_complaint"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Catatan</strong></td>
                                <td> : </td>
                                <td>
                                    <span id="note_complaint"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12" id="image_detail" style="display: none">
                        <table width="100%">
                            <thead class="text-center">
                                <tr>
                                    <th width="50%">Gambar</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td>
                                        <img src="" alt="Gambar" id="image_complaint" class="img-fluid">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12" id="image_follow_up_detail" style="display: none">
                        <table width="100%">
                            <thead class="text-center">
                                <tr>
                                    <th width="50%">Gambar Tindak Lanjut</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td>
                                        <img src="" alt="Gambar" id="image_follow_up" class="img-fluid">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger ms-auto" data-bs-dismiss="modal">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-square-rounded-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 10l4 4m0 -4l-4 4" />
                        <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                    </svg>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
