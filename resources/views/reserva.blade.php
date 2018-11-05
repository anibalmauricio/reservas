@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <template-component></template-component>            
        </div>
    </div>
</div>

@endsection
 
@isset($reserva)
<script type="text/javascript">
   window.__INITIAL_STATE__ = JSON.parse('{!! $reserva !!}');
</script>
@endisset