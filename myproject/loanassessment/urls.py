from django.urls import path
from . import views

urlpatterns = [
    path('', views.train_and_predict_model, name='loan_eligibility'),  # Ensure that this matches the root of the loanassessment app
]
