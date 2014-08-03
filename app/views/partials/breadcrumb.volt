<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ name['main'] }}&nbsp;.<small>{{ name['sub'] }}</small></h2>

        <ol class="breadcrumb">
            <li><a href="{{ url('dashboard/index') }}">Home</a></li>
            <li>{{ name['main'] }}</li>
            <li class="active"><strong>{{ name['sub'] }}</strong></li>
        </ol>
    </div>
</div>