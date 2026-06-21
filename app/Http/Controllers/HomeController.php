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
 * employees, service items and service orders. It also loads important
 * order lists, such as today's orders, upcoming deadlines and overdue orders.
 */
class HomeController extends Controller
{
    /**
     * Displays the home page with dashboard statistics and order summaries.
     *
     * The method retrieves active service orders, calculates the total order value,
     * counts records used in dashboard cards and prepares additional order lists
     * for today's schedule, upcoming deadlines and overdue work.
     */
    public function index()
    {
        // Retrieve all active service orders with their related service items.
        // These records are used to calculate the total value of active orders.
        $serviceOrders = ServiceOrder::with('serviceItems')->where('IsActive', true)->get();

        // Calculate the total value of all active service orders.
        // Each order value is calculated as the sum of prices of its related service items.
        $totalOrderValue = $serviceOrders->sum(function ($order) 
        {
            return $order->serviceItems->sum('Price');
        });

        // Retrieve active service orders scheduled for today.
        // Related client, employees and service items are loaded for display on the dashboard.
        $todayOrders = ServiceOrder::with(['client', 'employees', 'serviceItems'])
            ->where('IsActive', true)
            ->whereDate('StartDateTime', today())
            ->orderBy('StartDateTime')
            ->get();

        // Retrieve active orders with deadlines coming within the next 7 days.
        // Completed and cancelled orders are excluded because they no longer require action.
        $upcomingDeadlineOrders = ServiceOrder::with(['client', 'serviceItems'])
            ->where('IsActive', true)
            ->whereNotIn('Status', ['Completed', 'Cancelled'])
            ->whereDate('Deadline', '>=', today())
            ->whereDate('Deadline', '<=', today()->copy()->addDays(7))
            ->orderBy('Deadline')
            ->get();

        // Retrieve active orders that are already overdue.
        // Completed and cancelled orders are excluded from the overdue list.
        $overdueOrders = ServiceOrder::with(['client', 'serviceItems'])
            ->where('IsActive', true)
            ->whereNotIn('Status', ['Completed', 'Cancelled'])
            ->where('Deadline', '<', now())
            ->orderBy('Deadline')
            ->get();

        // Return the dashboard view with all calculated statistics and order lists.
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

            'todayOrders' => $todayOrders,
            'upcomingDeadlineOrders' => $upcomingDeadlineOrders,
            'overdueOrders' => $overdueOrders,
        ]);
    }
}