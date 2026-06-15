<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\ServiceItem;
use App\Models\ServiceOrder;

/**
 * Handles the main dashboard/home page of the application.
 * 
 * This controller prepares summary statistics for active clients,
 * employees, service items, service orders and order statuses.
 */
class HomeController extends Controller
{
    /**
     * Displays the home page with dashboard statistics.
     * 
     * The method retrieves active service orders together with their related
     * service items, calculates the total value of all active orders and
     * counts records used on the dashboard.
     */
    public function index()
    {
        // Retrieve all active service orders with their related service items.
        $serviceOrders = ServiceOrder::with('serviceItems')
            ->where('IsActive', true)
            ->get();

        // Calculate the total value of all active service orders.
        // The value of each order is calculated as the sum of its service item prices.
        $totalOrderValue = $serviceOrders->sum(function ($order) {
            return $order->serviceItems->sum('Price');
        });

        // Return the welcome view with all dashboard statistics.
        return view('welcome', [
            'activeClientsCount' => Client::where('IsActive', true)->count(),
            'activeEmployeesCount' => Employee::where('IsActive', true)->count(),
            'activeServiceItemsCount' => ServiceItem::where('IsActive', true)->count(),
            'activeServiceOrdersCount' => $serviceOrders->count(),
            'totalOrderValue' => $totalOrderValue,

            'newOrdersCount' => ServiceOrder::where('IsActive', true)->where('Status', 'New')->count(),
            'inProgressOrdersCount' => ServiceOrder::where('IsActive', true)->where('Status', 'In Progress')->count(),
            'completedOrdersCount' => ServiceOrder::where('IsActive', true)->where('Status', 'Completed')->count(),
            'cancelledOrdersCount' => ServiceOrder::where('IsActive', true)->where('Status', 'Cancelled')->count(),
        ]);
    }
}