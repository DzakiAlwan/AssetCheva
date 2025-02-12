<div class="modal fade" id="modal-delete-{{ $peminjam->id }}">
    <div class="modal-dialog">
        <form action="/peminjam/{{ $peminjam->id }}" method="post">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus ini???</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="sumbit" class="btn btn-outline-danger">Yaaa!!!</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
