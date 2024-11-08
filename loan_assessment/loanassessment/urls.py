from django.urls import path
from . import views

urlpatterns = [
    path('', views.index, name='index'),  # Home page
    path('loan_form/', views.train_and_predict_model, name='loan_form'),  # Loan form page
]
