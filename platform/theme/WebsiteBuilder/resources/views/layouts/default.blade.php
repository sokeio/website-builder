<!doctype html>
<html>
<head>
    @themeHead
    
</head>
<body x-data="sokeioBody()">
    @themeBody
    @yield('content')
    @themeBodyEnd
    
</body>
</html>
