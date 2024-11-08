from django.urls import path
from . import views

urlpatterns = [
    path('', views.loan_eligibility, name='loan_eligibility'),  # Ensure that this matches the root of the loanassessment app
]
