Courier Service – Coding Challenge

This project solves the Everest Engineering Courier Service Coding Challenge, which consists of two independent problems:

Delivery Cost Estimation with Offers

Delivery Time Estimation using Vehicle Scheduling

The solution is implemented using PHP 8.4, Symfony Console, and PHPUnit 12, following clean architecture and SOLID principles.

📌 **Problem 1:** Delivery Cost Estimation with Offers
**Description**

Calculate the total delivery cost for each package using the formula:

Delivery Cost = Base Delivery Cost
              + (Package Weight × 10)
              + (Distance × 5)


If a valid offer code is applied and its criteria are met, a discount is applied.

**Key Rules**

Only one offer code per package

If offer code is invalid or criteria not met → discount = 0

Offers are extensible via the Strategy pattern

Input Format (input_cost.txt)

base_delivery_cost no_of_packages

pkg_id weight distance offer_code

...

Example

100 3

PKG1 5 5 OFR001

PKG2 15 5 OFR002

PKG3 10 100 OFR003


Output Format
pkg_id discount total_cost

Example Output

PKG1 0 175

PKG2 0 275

PKG3 35 665


**Run Problem 1**
php bin/console app:calculate-cost < input_cost.txt

📌 **Problem 2: ** Delivery Time Estimation
Description

Estimate delivery time for each package using a fleet of vehicles while maximizing delivery efficiency.

Each vehicle:

Has a maximum carriable weight

Travels at the same speed

Returns to the source after every trip

Delivery Rules

Maximize number of packages per shipment

If tie → prefer higher total weight

If tie → prefer earliest deliverable shipment

Delivery time for a package:

delivery_time = vehicle_start_time + (distance / speed)

Input Format (input_delivery.txt)

base_delivery_cost no_of_packages

pkg_id weight distance offer_code

...

no_of_vehicles max_speed max_carriable_weight

Example

100 5

PKG1 50 30 OFR001

PKG2 75 125 NA

PKG3 175 100 OFR003

PKG4 110 60 OFR002

PKG5 155 95 NA

2 70 200


Output Format
pkg_id discount total_cost estimated_delivery_time

Example Output

PKG1 0 750 3.98

PKG2 0 1475 1.78

PKG3 0 2350 1.42

PKG4 105 1395 0.85

PKG5 0 2125 4.19


**Run Problem 2**
php bin/console app:calculate-courier < input_delivery.txt

🧠 Architecture & Design Decisions
✔ Clean Architecture

Domain → Package, Vehicle, Offer

Service → CostCalculator, DeliveryScheduler

Command → Console entry points

✔ Strategy Pattern (Offers)

Each offer implements OfferInterface, making the system open for extension without modifying existing logic.

✔ Scheduling Algorithm

Evaluates all valid package combinations

Guarantees PDF-accurate shipment selection

Uses full precision for calculations and rounds only at output

🧪 Testing (PHPUnit 12)

Unit tests validate:

Cost calculation logic

Offer resolution

Delivery time scheduling

Run Tests
php bin/phpunit


✔ PHPUnit 12 compatible
✔ PHP 8.4 compatible
✔ Zero warnings / notices

🛠 Tech Stack

PHP 8.4

Symfony Console

PHPUnit 12

Composer

📎 Notes

Floating-point precision is preserved internally.

Rounding is applied only during output formatting.

The solution strictly follows the rules provided in the challenge PDF.

👩‍💻 Author

Rajeshwari Nesargi

Senior PHP / Backend Engineer
