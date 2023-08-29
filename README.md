## Order Picking System

There is a back-end for order picking process:

- Usage
- Database schema.
- Api design.
- Picking Logic

### Usage
there is factories and seeders for dummy data
    
    php artisan migrate:fresh --seed

and there is jobs run every minute to handle auto processes

    php artisan schedule:work 
    php artisan queue:work

### Database schema
- assignments
- locations
- order_products
- orders
- product_locations
- products
- roles
- time_slots
- users

-- the database includes users and each user has some roles (picker, business_owner, ..) Then we have the orders that can placed with many products, and every product was placed in any location and there are time slots to specify the delivery time

## Apis design

there is a APIs for:
- list pickers
- list orders
- list picked orders
- manual order assign to picker
- picker login
- list assigned orders for a picker
- get best route (get the shortest path to pick orders)
- get products of assigned order
- Pick single product

## Picking Logic
Each picker has an order capacity and each order has a "priority" attribute The auto-assignment process gets the orders by priority and batched and checks for the available pickers to assign this (Batch Picking Method)
then when the picker starts collecting the products he can get The best route from his location to the first product he should start with. 
also there is a process keep checks every minute for if there is orders and available pickers to assign
and another process to check if order collected to get the nearest timeslot and assign to then make order status completed
  
