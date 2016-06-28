<br/>

Environment: {{App::environment()}} <br/>

Domain: {{domain()}}

<hr/>

Error message: "{{$exception->getMessage()}}" <br/>
Error Line: "{{$exception->getLine()}}" <br/>
Error File: "{{$exception->getFile()}}" <br/>
Error Code: "{{$exception->getCode()}}" <br/>
Request URL:  "{{form_action_full()}}" <br/>
Request Method: "{{app('request')->method()}}"

<hr/>

Session ID: {{session()->get('user.sessionID')}} <br/>
User ID: {{session()->get('user.userID')}} <br/>
User Security Group: {{session()->get('user.userSecurityGroup')}} <br/>
Debug Sproc: {{session()->get('user.debugSproc')}} <br/>
Audit Screen Visit: {{session()->get('user.auditScreenVisit')}} <br/>
Company Name: {{session()->get('user.companyName')}} <br/>
Default Facility Id: {{session()->get('user.defaultFacilityId')}} <br/>

<br/>
User Ip: {{userIp()}} <br/>
Device Type: {{Device::type()}} <br/>

<hr/>

Error Trace: "{{$exception->getTraceAsString()}}" <br/>


