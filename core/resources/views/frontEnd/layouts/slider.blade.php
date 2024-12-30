<?php
$SliderBanners = Helper::BannersList(Helper::GeneralWebmasterSettings("home_banners_section_id"));
?>
@if(count($SliderBanners)>0)
    <section id="hero">
        <div class="hero-container hero-slider">
            @foreach($SliderBanners->slice(0,1) as $SliderBanner)
                <?php
                try {
                    $SliderBanner_type = $SliderBanner->webmasterBanner->type;
                } catch (Exception $e) {
                    $SliderBanner_type = 0;
                }
                ?>
            @endforeach
            <?php
            $title_var = "title_" . @Helper::currentLanguage()->code;
            $title_var2 = "title_" . config('smartend.default_language');
            $details_var = "details_" . @Helper::currentLanguage()->code;
            $details_var2 = "details_" . config('smartend.default_language');
            $file_var = "file_" . @Helper::currentLanguage()->code;
            $file_var2 = "file_" . config('smartend.default_language');
            ?>
            @if($SliderBanner_type==0)
                {{-- Text/Code Banners--}}
                <div class="text-center">
                    @foreach($SliderBanners as $SliderBanner)
                        <?php
                        if ($SliderBanner->$details_var != "") {
                            $BDetails = $SliderBanner->$details_var;
                        } else {
                            $BDetails = $SliderBanner->$details_var2;
                        }
                        ?>
                        @if($BDetails !="")
                            <div>{!! $BDetails !!}</div>
                        @endif
                    @endforeach
                </div>
            @elseif($SliderBanner_type==1)
                {{-- Photo Slider Banners--}}
                <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel"
                     data-bs-interval="5000">

                    <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

                    <div class="carousel-inner">

                        @php($i=0)
                        @foreach($SliderBanners as $SliderBanner)
                            <?php
                            if ($SliderBanner->$title_var != "") {
                                $BTitle = $SliderBanner->$title_var;
                            } else {
                                $BTitle = $SliderBanner->$title_var2;
                            }
                            $BDetails = $SliderBanner->$details_var;
                            if ($SliderBanner->$file_var != "") {
                                $BFile = $SliderBanner->$file_var;
                            } else {
                                $BFile = $SliderBanner->$file_var2;
                            }
                            ?>
                            <div
                                class="lazyload carousel-item {{ ($i==0)?"active":"" }} {{ ($BDetails =="" && $SliderBanner->link_url=="")?"carousel-item-clear":"" }}"
                                style="background-image: url('{{ URL::to('uploads/banners/'.$BFile) }}');">
                                <div class="carousel-container">
                                    <div class="carousel-content container">
                                        <div class="slider-content">
                                            @if($BDetails !="" || $SliderBanner->link_url!="")
                                                @if($BTitle !="")
                                                    <h2 class="animate__animated animate__fadeInDown slider-title">{!! $BTitle !!}</h2>
                                                @endif

                                                @if($BDetails !="")
                                                    <p class="animate__animated animate__fadeInUp slider-details">{!! nl2br($BDetails) !!}</p>
                                                @endif

                                                @if($SliderBanner->link_url !="")
                                                    <a href="{!! $SliderBanner->link_url !!}"
                                                       class="btn-theme animate__animated animate__fadeInUp slider-link">{{ __('frontend.moreDetails') }}</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php($i++)
                        @endforeach
                    </div>
                    @if(count($SliderBanners) >1)
                        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                        </a>
                    @else
                        <style>
                            .carousel-indicators {
                                display: none;
                            }
                        </style>
                    @endif
                </div>
            @else
                {{-- Video Banners--}}
                <div class="text-center">
                    @foreach($SliderBanners as $SliderBanner)
                        <?php
                        if ($SliderBanner->$title_var != "") {
                            $BTitle = $SliderBanner->$title_var;
                        } else {
                            $BTitle = $SliderBanner->$title_var2;
                        }
                        if ($SliderBanner->$details_var != "") {
                            $BDetails = $SliderBanner->$details_var;
                        } else {
                            $BDetails = $SliderBanner->$details_var2;
                        }
                        if ($SliderBanner->$file_var != "") {
                            $BFile = $SliderBanner->$file_var;
                        } else {
                            $BFile = $SliderBanner->$file_var2;
                        }
                        ?>
                        @if($SliderBanner->youtube_link !="")
                            @if($SliderBanner->video_type ==1)
                                <?php
                                $Youtube_id = Helper::Get_youtube_video_id($SliderBanner->youtube_link);
                                ?>
                                @if($Youtube_id !="")
                                    {{-- Youtube Video --}}
                                    <iframe width="100%" height="500" frameborder="0" allowfullscreen
                                            src="https://www.youtube.com/embed/{{ $Youtube_id }}?autoplay=1&mute=1"
                                            allow="autoplay">
                                    </iframe>
                                @endif
                            @elseif($SliderBanner->video_type ==2)
                                <?php
                                $Vimeo_id = Helper::Get_vimeo_video_id($SliderBanner->youtube_link);
                                ?>
                                @if($Vimeo_id !="")
                                    {{-- Vimeo Video --}}
                                    <iframe width="100%" height="500" frameborder="0" allowfullscreen
                                            src="https://player.vimeo.com/video/{{ $Vimeo_id }}?title=0&amp;byline=0">
                                    </iframe>
                                @endif
                            @endif
                        @endif
                        @if($SliderBanner->video_type ==0)
                            @if($BFile !="")
                                {{-- Direct Video --}}
                                <div class="video-wrapper">
                                <video controls autoplay muted playsinline>
                                    <source src="{{ URL::to('uploads/banners/'.$BFile) }}"
                                            type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                </div>
                            @endif
                        @endif
                        @if($BDetails !="")
                            <div>{!! $BDetails !!}</div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif

<style>
       .video-wrapper {
    position: relative;
    width: 100%;
    max-width: 100%; /* Menambahkan max-width untuk mencegah video melebihi lebar layar */
    overflow: hidden; /* Mengatasi masalah overflow */
    margin-bottom: 20px; /* Contoh margin bawah untuk memisahkan video dengan konten lainnya */
}

.video-wrapper video {
    width: 100%; /* Menyebabkan video mengisi lebar kontainer */
    height: auto; 
}
      /* Untuk ukuran layar laptop 1440x900 */
@media screen and (max-width: 1440px) {
    .video-wrapper video {
        max-width: 87%; /* Video mengisi lebar kontainer */
        height: auto; /* Mengikuti rasio aspek aslinya*/
        margin : 0 auto;
}
}
/* Untuk perangkat mobile */
/* Untuk perangkat mobile */
@media screen and (max-width: 576px) {
    .video-wrapper {
        display: flex; /* Menggunakan flexbox */
        align-items: center; /* Pusatkan video secara vertikal */
    }

    .video-wrapper video {
        max-width: 100%; /* Maksimum lebar video adalah 100% dari kontainer */
        height: 100%; /* Mengikuti rasio aspek aslinya */
        
    }
}
}
</style>
