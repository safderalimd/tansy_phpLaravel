<br/>

Domain: {{session()->get('dbConnectionData.login_domain')}} <hr/><br/><br/>

Error message: "{{$exception->getMessage()}}" <hr/><br/><br/>
Error Line: "{{$exception->getLine()}}" <hr/><br/><br/>
Error File: "{{$exception->getFile()}}" <hr/><br/><br/>
Error Code: "{{$exception->getCode()}}" <hr/><br/><br/>

Session ID: {{session()->get('user.sessionID')}} <hr/><br/><br/>
User ID: {{session()->get('user.userID')}} <hr/><br/><br/>
User Security Group: {{session()->get('user.userSecurityGroup')}} <hr/><br/><br/>
Debug Sproc: {{session()->get('user.debugSproc')}} <hr/><br/><br/>
Audit Screen Visit: {{session()->get('user.auditScreenVisit')}} <hr/><br/><br/>
Company Name: {{session()->get('user.companyName')}} <hr/><br/><br/>
Default Facility Id: {{session()->get('user.defaultFacilityId')}} <hr/><br/><br/>

Error Trace: "{{$exception->getTraceAsString()}}" <hr/><br/><br/>


