@php
    if ($stage === 'lembur' || $stage === 'perjadin') {
        $array = array($model->approve_kf, $model->approve_binagram, $model->approve_ppk, $model->approve_kepala);
        arsort($array);
        if(array_sum($array) === 0) {
            echo "<span class='badge badge-info font-weight-bold'>
                        <i class='fa fa-spinner'></i>
                        <span class='ml-1'>Proses Pemeriksaan</span>
                </span>";
        } elseif(count(array_unique($array)) === 1) {
            echo "<span class='badge badge-primary font-weight-bold'>
                        <i class='far fa-check-circle'></i>
                        <span class='ml-1'>Diterima</span>
                </span>";
        } else {
            for($i = 0 ; $i < count($array); $i++) {
                if($array[$i] === 0) {
                    echo "<span class='badge badge-info font-weight-bold'>
                                <i class='fa fa-spinner'></i>
                                <span class='ml-1'>Proses Pemeriksaan</span>
                        </span>";
                    break;
                } elseif($array[$i] === 2) {
                    echo "<span class='badge badge-danger font-weight-bold'>
                                <i class='far fa-times-circle'></i>
                                <span class='ml-1'>Ditolak</span>
                        </span>";
                    break;
                } else {
                    continue;
                }
            }
        }
    } else {
        $array = array($model->approve_kf, $model->approve_binagram, $model->approve_ppk);
        arsort($array);
        if(array_sum($array) === 0) {
            echo "<span class='badge badge-info font-weight-bold'>
                        <i class='fa fa-spinner'></i>
                        <span class='ml-1'>Proses Pemeriksaan</span>
                </span>";
        } elseif(count(array_unique($array)) === 1) {
            echo "<span class='badge badge-primary font-weight-bold'>
                        <i class='far fa-check-circle'></i>
                        <span class='ml-1'>Diterima</span>
                </span>";
        } else {
            for($i = 0 ; $i < count($array); $i++) {
                if($array[$i] === 0) {
                    echo "<span class='badge badge-info font-weight-bold'>
                                <i class='fa fa-spinner'></i>
                                <span class='ml-1'>Proses Pemeriksaan</span>
                        </span>";
                    break;
                } elseif($array[$i] === 2) {
                    echo "<span class='badge badge-danger font-weight-bold'>
                                <i class='far fa-times-circle'></i>
                                <span class='ml-1'>Ditolak</span>
                        </span>";
                    break;
                } else {
                    continue;
                }
            }
        }
    }
@endphp
