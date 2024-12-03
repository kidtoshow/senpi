@extends('layouts.sbadmin')

@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            {!! $form !!}
        </div>
    </div>
    <script>
        document.newebform.submit();
    </script>
@endsection