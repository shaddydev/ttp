<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Travel Trip Plus</title>
        <!-- <link href="https://fonts.googleapis.com/css?family=roboto:300,300i,400,400i,500,500i,600,700,800,900" rel="stylesheet"> -->
    </head>
    <body style="background-color: #f1f1f1; font-family: roboto, sans-serif; font-size: 15px; margin: 0; padding: 0;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="background: #f1f1f1; font-family: 'roboto', sans-serif; font-size: 14px;">
            <tr>
                <td align="center">
                    <table border="0" cellpadding="10" cellspacing="0" width="600" align="center">
                        <tr>
                            <td align="center">
                                <table border="0" cellpadding="10" cellspacing="0" width="600">
                                    <tr>
                                        <td align="center"><a href=""><img src="{{ url('public/uploads/siteinfo/resizepath/'.$sitelogo) }}"></a></td>
                                    </tr>
                                </table>
                                <table border="0" cellpadding="10" cellspacing="10" width="600" style="background: #fff; border:3px solid #ddd;">
                                    <tr>
                                        <td align="center" style="font-size: 30px; font-weight: bold; color: #222; letter-spacing: 1px; border-bottom:2px solid #ea1b36;">
                                            <?php if(isset($titledata)){ echo $titledata; } ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 16px;"><?php if(isset($subjectdata)){ echo $subjectdata; } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        @if(isset($verificationlink))
                                            <a href="{{ url('user/mailconfirmation/'.$verificationlink) }}" class="btn btn-primary">Click here</a>
                                        @endif

                                        @if(isset($details))
                                            @foreach($details as $key=>$value)
                                                <b>{{ $key }}= </b>{{ $value }}
                                                <br>
                                       
                                            @endforeach
                                        @endif
                                        </td>
                                    </tr>
                                    
<tr>
                                        <td align="right">Team, <br/><a href="{{ $homelink }}"> TravelTripPlus</a></td>
                                    </tr>
                                    </table>
                                    </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>