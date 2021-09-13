<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REPORT SHEET</title>
    <style>
        body{
            font-family: 'Open Sans', sans-serif;
        }
        #watermark {
            position: fixed;
            top: 50%;
            left: 25%;
            transform: translate(-50%, -50%);
            z-index:  -1000;
        }
    </style>
</head>
<body>
<div id="watermark">
    <img style="opacity: 0.1" src="https://digikraaft.ng/front/images/logo.png"/>
</div>

<main>

    <p style="text-align: center; text-transform: uppercase">{{$schoolDetails['schoolName']}}</p>
    <p style="text-align: center; font-size: 12px;">{{$schoolDetails['schoolLocation']}}</p>
    <p style="text-align: center; font-size: 12px;">
        <span>{{$schoolDetails['contactNumber']}}</span>
        |
        <span>{{$schoolDetails['contactEmail']}}</span>
    </p>
    <h3 style="text-align: center;">REPORT SHEET</h3>
    <p style="text-align: center;">
        <span style="text-transform: capitalize;">{{$sessionInWord}}</span> -
        <span>{{$result->student->classArm->schoolClass->class_name}}</span>
        <span>
            {{$result->student->classArm->classSection ?
               $result->student->classArm->classSection->section_name : ''}}
        </span>
        <span>
        {{$result->student->classArm->classSection->classSectionCategory ?
            $result->student->classArm->classSection->classSectionCategory->category_name : ''}}
        </span>
    </p>
    <table style="height: 78px; width: 80%; border-collapse: collapse; border-style: dotted; margin-left: auto; margin-right: auto;" border="1" cellspacing="2" cellpadding="2">
        <tbody>
        <tr style="height: 78px;">
            <td style="width: 33.3333%; height: 78px; text-transform: uppercase;">
                <strong>{{$result->student->first_name}}</strong>
                <span>{{$result->student->other_name}}</span>
                <span>{{$result->student->last_name}}</span>
            </td>
            <td style="width: 33.3333%; height: 78px; font-size: 12px;">
                <p>Gender: {{$result->student->gender}}</p>
                <p>No in class:</p>
            </td>
            <td style="width: 33.3333%; height: 78px; font-size: 12px;">
                <p>
                    <strong>POSITION: {{strOrdinal($result->class_position)}}</strong>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table style="border-collapse: collapse; width: 100%;" border="1">
        <thead>
        <tr style="background-color: #eceff3; font-size: 10px;">
            <th style="width: 1%; text-align: center;">S/N</th>
            <th style="width: 20%; text-align: center;">SUBJECT</th>
            @foreach($result['ca_format'] as $caFormat)
            <th style="width: 12.5%; text-align: center;">
                <span style="text-transform: lowercase;">{{$caFormat['name']}}</span>
                <p>
                    ({{$caFormat['score']}}%)
                </p>
            </th>
            @endforeach
            <th style="width: 12.5%; text-align: center;">TOTAL (100%)</th>
            <th style="width: 12.5%; text-align: center;">SUBJECT POS.</th>
            <th style="width: 12.5%; text-align: center;">CLASS AVG. (100%)</th>
            <th style="width: 1%; text-align: center;">GRADE</th>
            <th style="width: 25%; text-align: center;">GRADE REMARK</th>
        </tr>
        </thead>
        <tbody>
        @foreach($subjects as $key => $subject)
        <tr>
            <td style="width: 1%; text-align: center;">{{$key + 1}}</td>
            <td style="width: 20%; padding-left: 2px; text-transform: uppercase; font-size: 13px; text-align: center;">{{$subject['subjectName']}}</td>
            @foreach($result['ca_format'] as $caFormat)
            <td style="width: 12.5%; text-align: center;">
                {{$subject[$caFormat['name']]}}
            </td>
            @endforeach
            <td style="width: 12.5%; text-align: center;">{{$subject['total']}}</td>
            <td style="width: 12.5%; text-align: center;">{{strOrdinal($subject['subjectMetric']['SubjectPosition'])}}</td>
            <td style="width: 12.5%; text-align: center;">{{$subject['subjectMetric']['classAverage']}}</td>
            <td style="width: 1%; text-align: center; text-transform: uppercase;font-size: 13px">
                {{$subject['grade']}}
            </td>
            <td style="width: 25%; text-align: center; text-transform: uppercase; font-size: 13px">{{$subject['gradeRemark']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <p>&nbsp;</p>
    <p>GRADES FORMAT:</p>
    <div>
        @foreach($result->grading_format as $gradingFormat)
            <p>
                <span style="text-transform: uppercase">{{$gradingFormat['grade']}}:</span>
                {{$gradingFormat['from']}} - {{$gradingFormat['to']}}
                <span style="text-transform: capitalize; font-size: 13px;">{{$gradingFormat['comment']}}</span>
            </p>
        @endforeach
    </div>

    <p>&nbsp;</p>
    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
        <tr>
            <td style="width: 50%;">
                <p>Dated: today</p>
                <p>
                    <img width="18%"
                         src="data:image/png;base64,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">
                </p>
                <p><span style="text-decoration: underline; text-transform: capitalize">{{$principal['principalName']}}</span></p>
                <p><em>Principal</em></p>
            </td>
            <td style="width: 50%;">
                stamp
            </td>
        </tr>
        </tbody>
    </table>

</main>


</body>
</html>
