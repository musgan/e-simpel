@php
use \App\Helpers\VariableHelper;
use \App\Helpers\CostumHelpers;
@endphp
@if($all_setting_periode !== null & $isAuthorizeToAction == true)
    <div class="alert alert-info" role="alert">
        <h5 class="alert-heading">Informasi batas penginputan data</h5>
        @if(count($all_setting_periode) > 1)
            <ol type="a">
                @foreach($all_setting_periode as $row_setting_periode)
                    <li>Batas waktu periode {{implode(" ",[VariableHelper::getMonthName($row_setting_periode->periode_bulan),$row_setting_periode->periode_tahun])}}
                        <ul>
                            <li>
                                Hawasbid  {{implode(" - ",[CostumHelpers::getDateDMY($row_setting_periode->start_input_session),CostumHelpers::getDateDMY($row_setting_periode->stop_input_session)])}}
                            </li>
                            <li>
                                Tindak lanjut  {{implode(" - ",[CostumHelpers::getDateDMY($row_setting_periode->start_periode_tindak_lanjut),CostumHelpers::getDateDMY($row_setting_periode->stop_periode_tindak_lanjut)])}}
                            </li>
                        </ul>
                    </li>
                @endforeach
            </ol>
        @else
            @php
                $row_setting_periode = $all_setting_periode->first();
            @endphp

            Batas waktu periode {{implode(" ",[VariableHelper::getMonthName($row_setting_periode->periode_bulan),$row_setting_periode->periode_tahun])}}
            <ul>
                <li>
                    Hawasbid  {{implode(" - ",[CostumHelpers::getDateDMY($row_setting_periode->start_input_session),CostumHelpers::getDateDMY($row_setting_periode->stop_input_session)])}}
                </li>
                <li>
                    Tindak lanjut  {{implode(" - ",[CostumHelpers::getDateDMY($row_setting_periode->start_periode_tindak_lanjut),CostumHelpers::getDateDMY($row_setting_periode->stop_periode_tindak_lanjut)])}}
                </li>
            </ul>
        @endif
    </div>
@endif