@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Homepage Layouts')</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        @foreach (homepageLayouts() as $layout)
                            <div class="col-12 col-sm-6">
                                <div class="card shadow-none border">
                                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                                        <h6 class="card-title">{{ __(@$layout['name']) }}</h6>
                                        <form action="{{ route('admin.setting.home.layouts.update') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="name" value="{{ @$layout['key'] }}">
                                            <button type="submit" class="btn btn-sm {{ gs('homepage_layout') == @$layout['key'] ? 'btn--success' : 'btn--dark' }}">
                                                @if (gs('homepage_layout') == @$layout['key'])
                                                    @lang('Active')
                                                @else
                                                    @lang('Activate')
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                    @if (@$layout['image'])
                                        <div class="card-body">
                                            <img src="{{ asset('assets/admin/images/layouts/' . @$layout['image']) }}" alt="" class="w-100">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
