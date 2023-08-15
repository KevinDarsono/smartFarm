@extends('admin.layouts.base')

@section('meta_title', 'Manage Sensor ')
@section('page_title', 'Kalibrasi Page')
@section('page_title_icon')
<em class="metismenu-icon bi bi-columns-gap"></em>
@endsection

@section('content')

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4><strong>Generate Data</strong></h4>
            </div>
            <div class="card-body">
                <form id="generateForm" method="post" action="{{ route('calibrate.getdata', ['id' => $sensor->id ]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="startDate">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="startDate" name="start_date">
                    </div>
                    <div class="form-group">
                        <label for="startTime">Waktu Mulai</label>
                        <input type="time" class="form-control" id="startTime" name="start_time">
                    </div>
                    <div class="form-group">
                        <label for="endDate">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="endDate" name="end_date">
                    </div>
                    <div class="form-group">
                        <label for="endTime">Waktu Selesai</label>
                        <input type="time" class="form-control" id="endTime" name="end_time">
                    </div>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4><strong>Data {{ $sensor->sensor }}</strong></h4>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Created At</th>
                                <th>Modus</th>
                                <th>Alat Ukur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($dataKalibrasi) && $tableDisplayed)
                            @if (count($dataKalibrasi) > 0)
                            @foreach ($dataKalibrasi as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->created_at->format('l, d F Y H:i:s') }}</td>
                                <td>{{ $item->modus }}</td>
                                <td>{{ $item->alat_ukur }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <p>No data available for the selected range.</p>
                            </tr>
                            @endif
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<br>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4><strong>Linear Regression and R-squared Value</strong></h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <strong>Linear Regression Equation:</strong>
                        </p>
                        <p>
                            @if (empty($slope) && empty($intercept))

                            @else
                            y = {{ $slope }}x + {{ $intercept }}
                            @endif
                        </p>
                        <p>
                            @if (empty($slope) && empty($intercept))

                            @else
                            Where a (slope) is {{ $slope }} and b (intercept) is {{ $intercept }}.

                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>R-squared Value:</strong></p>
                        <p>R-squared value: </p>
                        <p>R-squared value represents the goodness of fit of the regression line to the data.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><br>


@endsection
