# from django.contrib import admin
# from django.urls import path, include
# from django.shortcuts import redirect

# urlpatterns = [
#     path('admin/', admin.site.urls),
#     path('loan/', include('loanassessment.urls')),  # Include the loan assessment app URLs
#     path('', lambda request: redirect('/loan/')),  # Redirect the root URL to /loan/
# ]

from django.contrib import admin
from django.urls import path, include
from django.shortcuts import redirect

urlpatterns = [
    path('admin/', admin.site.urls),
    path('loan/', include('loanassessment.urls')),  # Correctly include the loanassessment URLs
    path('', include('loanassessment.urls')),
    path('admin/', admin.site.urls),
    path('loan/', include('loanassessment.urls')),  # Correctly include the loanassessment URLs
    path('', include('loanassessment.urls')), 

   # path('', lambda request: redirect('/loan/')),  # Redirect the root URL to /loan/
]
