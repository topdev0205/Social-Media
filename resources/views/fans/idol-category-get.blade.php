@extends('layouts.fans')

@section('title', 'Personalized Videos & Fan Service from your Korean Wave Idols')

@section('styles')
<style>
.footer .container-fluid {
    padding: 0px!important;
}
.featured .image-part .row {
    flex-wrap: inherit;
}
.featured .image-item > img {
    min-height: 220px;
}
@media (max-width: 574px) {
    .container-fluid {
        padding: 10px!important;
    }
    .featured .image-item > img {
        min-height: 120px;
    }
}
</style>
@endsection

@section('content')
<div class="row featured mb-4 hide">
    <div class="col-12 col-sm-12 col-md-12">
        <div class="title-part">
            <h2 class="text-white">{{ $cat->cat_name }}</h2>
            <!-- <p class="text-grey">Influencer recommendation for you.</p> -->
            <div class="divider mb-4 desktop"></div>
        </div>
        <div class="image-part">
            <div class="row m-0">
                @if(count($idols))
                @foreach($idols as $idol)
                @php
                    $idol_info = DB::table('idol_info')->where('idol_user_id', $idol->id)->first();
                    $cats = json_decode($idol_info->idol_cat_id);
                @endphp
                <div class="col-4 col-sm-3 col-md-3 custom-col" data-url="{{ route('follow-idol', $idol_info->idol_user_name) }}">
                    <div class="image-item" style="position: initial">
                        <img src="{{ asset('assets/images/img/'.$idol_info->idol_photo) }}" class="w-100">    
                        <div class="gradient"></div>
                        <div class="image-profile">
                            <h5 class="text-white">{{ $idol_info->idol_full_name }}</h5>
                            <div class="d-flex" style="flex-wrap: wrap">
                                @foreach($cats as $cat)
                                @php
                                    $cat = DB::table('categories')->where('cat_id', $cat)->first();
                                @endphp
                                <p class="text-white mr-3 mb-0">{{ $cat->cat_name }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12 col-sm-12 col-md-12 d-flex" style="height: 200px">
                    <p class="text-white mb-0 text-center m-auto">No idols yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.show').hide();

        $('.custom-col').on('click', function() {
            var url = $(this).data('url');
            location.href = url;
        })
        
        $('.favourite-btn').on('click', function() {
            $(this).removeClass('deactive');
            $('.discover-btn').addClass('deactive');
            $('.hide').hide();
            $('.show').show();
        });

        $('.discover-btn').on('click', function() {
            $(this).removeClass('deactive');
            $('.favourite-btn').addClass('deactive');
            $('.hide').show();
            $('.show').hide();
        });
    })
</script>
@endsection