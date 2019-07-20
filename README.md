# Countrywide Market Reporting System

This project was made for database management lecture in my school. The project solely consists of php and some csv files for processing.

# Used Technologies
- PHP
- MySQL
- CanvasJS  (a javascript library for creating charts)

NOTE: main page in the application is "install.php"

# Project Requirements
1. CREATING TABLES OF THE PROJECT
(i) Create tables for holding DISTRICTs and CITYs of Turkey. (Example District: Marmara, City:
İstanbul)  
(ii) Create a table for holding MARKETs available in a city. (A101, Migros...)  
(iii) Create a table for holding information about a SALESMAN employeed in a market.  
(iv) Create a table to hold information about CUSTOMERs.  
(v) Create a table for PRODUCTs.(Cheese, Olive, Eggs...)  
(vi) Lastly, create a SALE table which holds a product's sale information, who bought the product  
(CUSTOMER) and who sold them (SALESMAN).  
Prepare an installation page with PHP (can be named as install.php) and when clicked on installation  
button, it should create the tables described above and fill these tables with the information described  
in Part 2.  
Warning: Name your database as your name_surname  
username of your database : root and password: mysql  


2. INSERTING ELEMENTS TO THE TABLES   
All districts and cities of Turkey should be held in an csv file and imported to the appropriate tables  
with install action.  
500 random Turkish Names and 500 random Turkish Surnames are to be held in an csv file and their  
combinations of 1620 full names should be inserted into CUSTOMER table. 1215 full names should
be inserted in the SALESMAN table  
You should have 200 randomly chosen product names that will be inserted to the PRODUCT table.  
You should define 10 different markets.  
Every city should have 5 different randomly chosen markets.  
Finally for every customer, you should have at most 5 sale item inserted with install action.  
Warning: Do not forget to include associated salesman who made the sale while inserting information  
about sales. Every market should have exactly 3 salesman who work there.  


3. REPORTING ACTIONS  
You are instructed to implement the following reporting actions in some PHP files:  
(A) After choosing the city in a select box, you should show for each market, how many products they  
sold. You should write a PHP file (can be named as ShowCitySalesInformation.php) for these  
selecting and showing actions.  
(B) After choosing a market, you should have three actions:  
(i) Click on a product button to see which product has been sold how many times.  
(ii) Click on a salesman button to see which salesman has sold how many products.  
(iii) Click on a choose salesman button, when a salesman of that market is chosen, you should show  
all the sale information of that salesman.  
(iv) After click on invoice button choose the customer who bought items in that market, then show  
his/her products, their prices, sale date and total cost.  
(C) When report button is clicked do the actions below in a single page:  
(a) Draw a piechart on all sales divided into districts.  
(b) Draw a piechart on all sales divided into markets.  
You should write a PHP file for both operations defined in Part B. (This file can be named as  
MarketSalesInformation.php). In this file you should create buttons associated for the actions defined  
above. For (A) and (B), use progress bars to show how many items or how many times an item sold.  

