@extends('app')

@section('app_content')
    <cheques-show :cheque_prop="{{ $cheque->toJson() }}" :actionvalues_prop="{{ $actionvalues }}" :hasexecrole_prop="{{ $hasexecrole }}" :userprofiles_prop="{{ $userprofiles }}"></cheques-show>
@endsection
