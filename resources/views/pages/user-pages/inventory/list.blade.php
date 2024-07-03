@forelse($items as $item)
    <div class="col-sm-4 col-lg-3">
        <div class="card card-sm">
            <a href="#" class="d-block"><img src="{{ asset('storage/' . $item->image_url) }}" height="250"
                    class="card-img-top"></a>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h3>{{ $item->name }}</h3>
                        <div class="text-secondary">
                            {{ $item->room->name }}
                        </div>
                        <div class="text-secondary">
                            Jumlah : {{ $item->amount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-md-12 text-center">
        <h3>Data inventaris tidak ditemukan.</h3>
    </div>
@endforelse
