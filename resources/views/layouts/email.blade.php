<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>CORTEX</title>
      <style>
         .ii a[href] {
         text-decoration: none !important;
         }
      </style>
   </head>
   <body>
      <table style="background-color:#F8F8F8" width="100%">
         <tr>
            <td>
               <table width="760" border="0" align="center" cellpadding="0" cellspacing="0" >
                  <tr>
                     <td align="center"><br /><br /><img src="{{asset("app/images/logo.svg")}}" width="30%" alt="logo"/><br /><br /></td>
                  </tr>
               </table>
               <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="background-color:#fff">
                  <tr>
                     <td width="20">&nbsp;</td>
                     <td width="760">
                        <table width="760" border="0" align="center" cellpadding="0" cellspacing="0" >
                           <tr>
                              <td >
                                 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                       <td style="font-family: Helvetica,Arial,sans-serif!important; line-height:24px; font-size:18px">
                                        <br />
                                        <div id="content">
                                          @yield('content')
                                        </div>
                                        <br />
                                       </td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                           <tr>
                              <td style="font-family: Helvetica,Arial,sans-serif!important; line-height:34px; font-size:15px;  color:#000">
                                 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                       <td >&nbsp;</td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                        </table>
                     </td>
                     <td width="20">&nbsp;</td>
                  </tr>
                  <tr>
                     <td style="background-color:#F8F8F8">&nbsp;</td>
                     <td style=" background-color:#F8F8F8; text-align:center"> <span style="font-family: Helvetica,Arial,sans-serif!important; line-height:34px; font-size:18px;  color:#000; "><br />©  {{ date('Y') }}  {{_('Copyright')}} - {!! _(env('APP_NAME')) !!}. All Rights Reserved.</span>    <br />    <br /></td>
                     <td style="background-color:#F8F8F8">&nbsp;</td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>
