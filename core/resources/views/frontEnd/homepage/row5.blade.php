<?php
$FAQLimit = 10; // 0 = all
$FAQs = Helper::Topics(Helper::GeneralWebmasterSettings("home_content7_section_id"), 0, $FAQLimit, 1);
$FAQs1 = @$FAQs->slice(0,5);
$FAQs2 = @$FAQs->slice(5,5);
?>
@if(count($FAQs)>0)
    <section id="faq" class="faq">
        <div class="container">
            <div class="section-title">
                <h2>{{ __('Pertanyaan yang Sering Diajukan') }}</h2>
                <h4>{{ __('Temukan Jawaban untuk Pertanyaan Anda') }}</h4>
            </div>

            <div class="accordion">
                <div class="row">
                    <?php
                    $i = 0;
                    $section_url = "";
                    ?>
                    <div class="col-lg-6 col-sm-12">
                        <div class="row">
                            @foreach($FAQs1 as $Topic)
                                <?php
                                if ($i == 2) {
                                    echo "</div><div class='row'>";
                                    $i = 0;
                                }
                                $i++;

                                if ($section_url == "") {
                                    $section_url = Helper::sectionURL($Topic->webmaster_id);
                                }
                                ?>
                                @include("frontEnd.topic.accordion",["Topic"=>$Topic,"CatId"=>0])
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="row">
                            @foreach($FAQs2 as $Topic)
                                <?php
                                if ($i == 2) {
                                    echo "</div><div class='row'>";
                                    $i = 0;
                                }
                                $i++;

                                if ($section_url == "") {
                                    $section_url = Helper::sectionURL($Topic->webmaster_id);
                                }
                                ?>
                                @include("frontEnd.topic.accordion",["Topic"=>$Topic,"CatId"=>0])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="more-btn">
                        <a href="{{ url($section_url) }}" class="btn btn-theme"><i
                                class="fa fa-angle-left"></i>&nbsp; {{ __('frontend.viewMore') }}
                            &nbsp;<i
                                class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endif
