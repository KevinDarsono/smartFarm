<div class="col-md-4">
    <a href="{{ route('lands.show', $land->id) }}" class="card mb-4" style="text-decoration:none;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ $land->image }}" alt="{{ $land->name }}" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">{{ $land->name }}</h5>
                    <div class="mb-2 mr-2 badge badge-info">{{ $land->crop_status }}</div>
                    <p class="card-text">{{ $land->description }}</p>
                </div>
            </div>
        </div>
    </a>
</div>
