from django.urls import path
from . import views

urlpatterns = [
    # path('', views.train_and_predict_model, name='loan_eligibility'),  # Ensure that this matches the root of the loanassessment app
    # path('', views.index, name='index'),  # This maps the root URL to the index view
    # path('loan_form/', views.train_and_predict_model, name='loan_form'),  # Add the loan_form path
    # path('', views.index, name='index'),  # This should route to the index page
    # path('loan_form/', views.train_and_predict_model, name='loan_form'),  # This should route to the loan form page

    path('', views.index, name='index'),  # This should route to the index page
    path('loan_form/', views.train_and_predict_model, name='loan_form'),

    # path('', views.train_and_predict_model, name='loan_eligibility'),  # This is root URL
    # path('', views.index, name='index'),  # This is also root, causing conflict
    # path('loan_form/', views.train_and_predict_model, name='loan_form'),
]
