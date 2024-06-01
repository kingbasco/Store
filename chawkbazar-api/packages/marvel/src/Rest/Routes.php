<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Marvel\Enums\Permission;
use Marvel\Http\Controllers\AbusiveReportController;
use Marvel\Http\Controllers\AddressController;
use Marvel\Http\Controllers\AiController;
use Marvel\Http\Controllers\AnalyticsController;
use Marvel\Http\Controllers\AttachmentController;
use Marvel\Http\Controllers\AttributeController;
use Marvel\Http\Controllers\AttributeValueController;
use Marvel\Http\Controllers\AuthorController;
use Marvel\Http\Controllers\CategoryController;
use Marvel\Http\Controllers\CheckoutController;
use Marvel\Http\Controllers\ConversationController;
use Marvel\Http\Controllers\CouponController;
use Marvel\Http\Controllers\DeliveryTimeController;
use Marvel\Http\Controllers\DownloadController;
use Marvel\Http\Controllers\FaqsController;
use Marvel\Http\Controllers\FeedbackController;
use Marvel\Http\Controllers\FlashSaleController;
use Marvel\Http\Controllers\FlashSaleVendorRequestController;
use Marvel\Http\Controllers\ManufacturerController;
use Marvel\Http\Controllers\MessageController;
use Marvel\Http\Controllers\OrderController;
use Marvel\Http\Controllers\PaymentIntentController;
use Marvel\Http\Controllers\PaymentMethodController;
use Marvel\Http\Controllers\ProductController;
use Marvel\Http\Controllers\QuestionController;
use Marvel\Http\Controllers\RefundController;
use Marvel\Http\Controllers\ResourceController;
use Marvel\Http\Controllers\ReviewController;
use Marvel\Http\Controllers\SettingsController;
use Marvel\Http\Controllers\ShippingController;
use Marvel\Http\Controllers\ShopController;
use Marvel\Http\Controllers\TagController;
use Marvel\Http\Controllers\TaxController;
use Marvel\Http\Controllers\TypeController;
use Marvel\Http\Controllers\UserController;
use Marvel\Http\Controllers\WebHookController;
use Marvel\Http\Controllers\WishlistController;
use Marvel\Http\Controllers\WithdrawController;
use Marvel\Http\Controllers\LanguageController;
use Marvel\Http\Controllers\NotifyLogsController;
use Marvel\Http\Controllers\RefundPolicyController;
use Marvel\Http\Controllers\RefundReasonController;
use Marvel\Http\Controllers\StoreNoticeController;
use Marvel\Http\Controllers\TermsAndConditionsController;

// use Illuminate\Support\Facades\Auth;

/**
 * ******************************************
 * Available Public Routes
 * ******************************************
 */

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verifyEmail'])->name('verification.verify');

Route::post('/register', [UserController::class, 'register']);
Route::post('/token', [UserController::class, 'token']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/forget-password', [UserController::class, 'forgetPassword']);
Route::post('/verify-forget-password-token', [UserController::class, 'verifyForgetPasswordToken']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::post('/contact-us', [UserController::class, 'contactAdmin']);
Route::post('/social-login-token', [UserController::class, 'socialLogin']);
Route::post('/send-otp-code', [UserController::class, 'sendOtpCode']);
Route::post('/verify-otp-code', [UserController::class, 'verifyOtpCode']);
Route::post('/otp-login', [UserController::class, 'otpLogin']);
Route::get('top-authors', [AuthorController::class, 'topAuthor']);
Route::get('top-manufacturers', [ManufacturerController::class, 'topManufacturer']);
Route::get('popular-products', [ProductController::class, 'popularProducts']);
Route::get('best-selling-products', [ProductController::class, 'bestSellingProducts']);
Route::get('check-availability', [ProductController::class, 'checkAvailability']);
Route::get("products/calculate-rental-price", [ProductController::class, 'calculateRentalPrice']);
Route::post('import-products', [ProductController::class, 'importProducts']);
Route::post('import-variation-options', [ProductController::class, 'importVariationOptions']);
Route::get('export-products/{shop_id}', [ProductController::class, 'exportProducts']);
Route::get('export-variation-options/{shop_id}', [ProductController::class, 'exportVariableOptions']);
Route::post('generate-description', [ProductController::class, 'generateDescription']);
Route::post('import-attributes', [AttributeController::class, 'importAttributes']);
Route::get('export-attributes/{shop_id}', [AttributeController::class, 'exportAttributes']);
Route::get('download_url/token/{token}', [DownloadController::class, 'downloadFile'])->name('download_url.token');
Route::get('export-order/token/{token}', [OrderController::class, 'exportOrder'])->name('export_order.token');
Route::post('subscribe-to-newsletter', [UserController::class, 'subscribeToNewsletter'])->name('subscribeToNewsletter');
Route::get('download-invoice/token/{token}', [OrderController::class, 'downloadInvoice'])->name('download_invoice.token');
Route::post('webhooks/razorpay', [WebHookController::class, 'razorpay']);
Route::post('webhooks/stripe', [WebHookController::class, 'stripe']);
Route::post('webhooks/paypal', [WebHookController::class, 'paypal']);
Route::post('webhooks/mollie', [WebHookController::class, 'mollie']);
Route::post('webhooks/paystack', [WebHookController::class, 'paystack']);
Route::post('webhooks/paymongo', [WebHookController::class, 'paymongo']);
Route::post('webhooks/xendit', [WebHookController::class, 'xendit']);
Route::post('webhooks/iyzico', [WebHookController::class, 'iyzico']);
Route::post('webhooks/bkash', [WebHookController::class, 'bkash']);
Route::post('webhooks/flutterwave', [WebHookController::class, 'flutterwave']);

Route::post('license-key/verify', [UserController::class, 'verifyLicenseKey']);

Route::get('callback/flutterwave', [WebHookController::class, 'callback'])->name('callback.flutterwave');

Route::get('near-by-shop/{lat}/{lng}', [ShopController::class, 'nearByShop']);

Route::get('store-notices', [StoreNoticeController::class, 'index'])->name('store-notices.index');

Route::apiResource('products', ProductController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('types', TypeController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('attachments', AttachmentController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('categories', CategoryController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('delivery-times', DeliveryTimeController::class, [
    'only' => ['index', 'show']
]);
Route::apiResource('languages', LanguageController::class, [
    'only' => ['index', 'show']
]);
Route::apiResource('tags', TagController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('refund-reasons', RefundReasonController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('resources', ResourceController::class, [
    'only' => ['index', 'show']
]);

Route::get('featured-categories', 'Marvel\Http\Controllers\CategoryController@fetchFeaturedCategories');

Route::apiResource('coupons', CouponController::class, [
    'only' => ['index', 'show'],
]);
Route::post('coupons/verify', [CouponController::class, 'verify']);
Route::apiResource('attributes', AttributeController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('shops', ShopController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('settings', SettingsController::class, [
    'only' => ['index'],
]);
Route::apiResource('reviews', ReviewController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('questions', QuestionController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('feedbacks', FeedbackController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('authors', AuthorController::class, [
    'only' => ['index', 'show'],
]);
Route::apiResource('manufacturers', ManufacturerController::class, [
    'only' => ['index', 'show'],
]);
Route::post('orders/checkout/verify', [CheckoutController::class, 'verify']);
Route::apiResource('orders', OrderController::class, [
    'only' => ['show', 'store'],
]);

Route::post('/email/verification-notification', [UserController::class, 'sendVerificationEmail'])
    ->middleware(['auth:sanctum', 'throttle:6,1'])
    ->name('verification.send');

Route::post('orders/payment', [OrderController::class, 'submitPayment']);
Route::post('generate-descriptions', [AiController::class, 'generateDescription']);
Route::get('/payment-intent', [PaymentIntentController::class, 'getPaymentIntent']);

Route::apiResource('faqs', FaqsController::class, [
    'only' => ['index', 'show'],
]);

Route::apiResource('terms-and-conditions', TermsAndConditionsController::class, [
    'only' => ['index', 'show'],
]);

Route::apiResource('flash-sale', FlashSaleController::class, [
    'only' => ['index', 'show'],
]);

Route::resource('refund-policies', RefundPolicyController::class, [
    'only' => ['index', 'show'],
]);


/**
 * ******************************************
 * Authorized Route for Customers only
 * ******************************************
 */

Route::group(['middleware' => ['can:' . Permission::CUSTOMER, 'auth:sanctum', 'email.verified']], function () {
    Route::post('/update-email', [UserController::class, 'updateUserEmail']);
    Route::get('me', [UserController::class, 'me']);
    Route::apiResource('orders', OrderController::class, [
        'only' => ['index'],
    ]);
    Route::apiResource('reviews', ReviewController::class, [
        'only' => ['store', 'update']
    ]);
    Route::apiResource('questions', QuestionController::class, [
        'only' => ['store'],
    ]);
    Route::apiResource('feedbacks', FeedbackController::class, [
        'only' => ['store'],
    ]);
    Route::apiResource('abusive_reports', AbusiveReportController::class, [
        'only' => ['store'],
    ]);
    Route::apiResource('conversations', ConversationController::class, [
        'only' => ['index', 'store'],
    ]);
    Route::get('conversations/{conversation_id}', [ConversationController::class, 'show']);
    Route::get('messages/conversations/{conversation_id}', [MessageController::class, 'index']);
    Route::post('messages/conversations/{conversation_id}', [MessageController::class, 'store']);
    Route::post('messages/seen/{conversation_id}', [MessageController::class, 'seen']);
    Route::get('my-questions', [QuestionController::class, 'myQuestions']);
    Route::get('my-reports', [AbusiveReportController::class, 'myReports']);
    Route::post('wishlists/toggle', [WishlistController::class, 'toggle']);
    Route::apiResource('wishlists', WishlistController::class, [
        'only' => ['index', 'store', 'destroy'],
    ]);
    Route::get('wishlists/in_wishlist/{product_id}', [WishlistController::class, 'in_wishlist']);
    Route::get('my-wishlists', [ProductController::class, 'myWishlists']);
    Route::get('orders/tracking-number/{tracking_number}', 'Marvel\Http\Controllers\OrderController@findByTrackingNumber');
    Route::apiResource('attachments', AttachmentController::class, [
        'only' => ['store', 'update', 'destroy'],
    ]);

    Route::put('users/{id}', [UserController::class, 'update']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::post('/update-contact', [UserController::class, 'updateContact']);
    Route::apiResource('address', AddressController::class, [
        'only' => ['destroy'],
    ]);
    Route::apiResource(
        'refunds',
        RefundController::class,
        [
            'only' => ['index', 'store', 'show'],
        ]
    );
    Route::get('downloads', [DownloadController::class, 'fetchDownloadableFiles']);
    Route::post('downloads/digital_file', [DownloadController::class, 'generateDownloadableUrl']);
    Route::get('/followed-shops-popular-products', [ShopController::class, 'followedShopsPopularProducts']);
    Route::get('/followed-shops', [ShopController::class, 'userFollowedShops']);
    Route::get('/follow-shop', [ShopController::class, 'userFollowedShop']);
    Route::post('/follow-shop', [ShopController::class, 'handleFollowShop']);
    Route::apiResource('cards', PaymentMethodController::class, [
        'only' => ['index', 'store', 'update', 'destroy'],
    ]);
    Route::post('/set-default-card', [PaymentMethodController::class, 'setDefaultCard']);
    Route::post('/save-payment-method', [PaymentMethodController::class, 'savePaymentMethod']);
    // Route::apiResource('faqs', FaqsController::class, [
    //     'only' => ['index', 'show'],
    // ]);

});

// Todo : Popular product on analytics route
// chawkbazar old code
// Route::get('popular-products', 'Marvel\Http\Controllers\AnalyticsController@popularProducts');
// Route::get('popular-products', 'Marvel\Http\Controllers\AnalyticsController@popularProducts');

// chawkbazar new code
Route::get('popular-products', 'Marvel\Http\Controllers\ProductController@popularProducts');

/**
 * ******************************************
 * Authorized Route for Staff & Store Owner
 * ******************************************
 */


Route::group(
    ['middleware' => ['permission:' . Permission::STAFF . '|' . Permission::STORE_OWNER, 'auth:sanctum', 'email.verified']],
    function () {
        Route::apiResource('products', ProductController::class, [
            'only' => ['store', 'update', 'destroy'],
        ]);
        Route::apiResource('resources', ResourceController::class, [
            'only' => ['store']
        ]);
        Route::apiResource('attributes', AttributeController::class, [
            'only' => ['store', 'update', 'destroy'],
        ]);
        Route::apiResource('attribute-values', AttributeValueController::class, [
            'only' => ['store', 'update', 'destroy'],
        ]);
        Route::apiResource('orders', OrderController::class, [
            'only' => ['update', 'destroy'],
        ]);

        // Route::get('shop-notification/{id}', [ShopNotificationController::class, 'show']);
        // Route::put('shop-notification/{id}', [ShopNotificationController::class, 'update']);
        // Route::get('popular-products', [AnalyticsController::class, 'popularProducts']);
        // Route::get('shops/refunds', 'Marvel\Http\Controllers\ShopController@refunds');
        Route::apiResource('questions', QuestionController::class, [
            'only' => ['update'],
        ]);
        Route::apiResource('authors', AuthorController::class, [
            'only' => ['store'],
        ]);
        Route::apiResource('manufacturers', ManufacturerController::class, [
            'only' => ['store'],
        ]);
        Route::get('store-notices/getStoreNoticeType', [StoreNoticeController::class, 'getStoreNoticeType']);
        Route::get('store-notices/getUsersToNotify', [StoreNoticeController::class, 'getUsersToNotify']);
        Route::post('store-notices/read/', [StoreNoticeController::class, 'readNotice']);
        Route::post('store-notices/read-all', [StoreNoticeController::class, 'readAllNotice']);
        Route::apiResource('store-notices', StoreNoticeController::class, [
            'only' => ['show', 'store', 'update', 'destroy']
        ]);

        Route::get('export-order-url/{shop_id?}', 'Marvel\Http\Controllers\OrderController@exportOrderUrl');
        Route::post('download-invoice-url', 'Marvel\Http\Controllers\OrderController@downloadInvoiceUrl');
        Route::apiResource('faqs', FaqsController::class, [
            'only' => ['store', 'update', 'destroy'],
        ]);
        Route::get('analytics', [AnalyticsController::class, 'analytics']);
        Route::get('low-stock-products', [AnalyticsController::class, 'lowStockProducts']);
        Route::get('category-wise-product', [AnalyticsController::class, 'categoryWiseProduct']);
        Route::get('category-wise-product-sale', [AnalyticsController::class, 'categoryWiseProductSale']);
        Route::get('draft-products', [ProductController::class, 'draftedProducts']);
        Route::get('products-stock', [ProductController::class, 'productStock']);
        Route::get('products-by-flash-sale', [FlashSaleController::class, 'getProductsByFlashSale']);
        Route::get('top-rate-product', [AnalyticsController::class, 'topRatedProducts']);
        Route::apiResource('coupons', CouponController::class, [
            'only' => ['update'],
        ]);
        // Route::get('products-requested-for-flash-sale-by-vendor', [FlashSaleVendorRequestController::class, 'getProductsByFlashSaleVendorRequest']);
        Route::get('requested-products-for-flash-sale', [FlashSaleVendorRequestController::class, 'getRequestedProductsForFlashSale']);
        Route::apiResource('vendor-requests-for-flash-sale', FlashSaleVendorRequestController::class, [
            'only' => ['index', 'show', 'store', 'destroy'],
        ]);
    }
);


/**
 * *****************************************
 * Authorized Route for Store owner Only
 * *****************************************
 */

Route::group(
    ['middleware' => ['permission:' . Permission::STORE_OWNER, 'auth:sanctum', 'email.verified']],
    function () {
        Route::apiResource('shops', ShopController::class, [
            'only' => ['store', 'update', 'destroy'],
        ]);
        // Route::get('analytics', [AnalyticsController::class, 'analytics']);
        Route::apiResource('withdraws', WithdrawController::class, [
            'only' => ['store', 'index', 'show'],
        ]);
        Route::post('staffs', [ShopController::class, 'addStaff']);
        Route::delete('staffs/{id}', [ShopController::class, 'deleteStaff']);
        Route::get('staffs', [UserController::class, 'staffs']);
        Route::get('my-shops', [ShopController::class, 'myShops']);
        // Route::get('/admin/list', [UserController::class, 'admins']);
        Route::apiResource('notify-logs', NotifyLogsController::class, [
            'only' => ['index'],
        ]);

        Route::post('notify-log-seen', [NotifyLogsController::class, 'readNotifyLogs']);
        Route::post('notify-log-read-all', [NotifyLogsController::class, 'readAllNotifyLogs']);

        // Route::apiResource('faqs', FaqsController::class, [
        //     'only' => ['store', 'update', 'destroy'],
        // ]);

        Route::apiResource('flash-sale', FlashSaleController::class, [
            'only' => ['store', 'update', 'destroy'],
        ]);

        Route::get('product-flash-sale-info', [FlashSaleController::class, 'getFlashSaleInfoByProductID']);

        Route::apiResource('terms-and-conditions', TermsAndConditionsController::class, [
            'only' => ['store', 'update', 'destroy'],
        ]);

        Route::apiResource('coupons', CouponController::class, [
            'only' => ['store', 'destroy'],
        ]);

        Route::apiResource('terms-and-conditions', TermsAndConditionsController::class, [
            'only' => ['store', 'update', 'destroy'],
        ]);
        // Route::post('products-request-for-flash-sale', [FlashSaleVendorRequestController::class, 'productsRequestForFlashSale']);
    }
);

/**
 * *****************************************
 * Authorized Route for Super Admin only
 * *****************************************
 */

Route::group(['middleware' => ['permission:' . Permission::SUPER_ADMIN, 'auth:sanctum', 'email.verified']], function () {
    // Route::get('messages/get-conversations/{shop_id}', [ConversationController::class, 'getConversationByShopId']);
    // Route::get('analytics', [AnalyticsController::class, 'analytics']);
    Route::apiResource('types', TypeController::class, [
        'only' => ['store', 'update', 'destroy'],
    ]);
    Route::apiResource('withdraws', WithdrawController::class, [
        'only' => ['update', 'destroy'],
    ]);
    Route::apiResource('categories', CategoryController::class, [
        'only' => ['store', 'update', 'destroy'],
    ]);
    Route::apiResource('delivery-times', DeliveryTimeController::class, [
        'only' => ['store', 'update', 'destroy']
    ]);
    Route::apiResource('languages', LanguageController::class, [
        'only' => ['store', 'update', 'destroy']
    ]);
    Route::apiResource('tags', TagController::class, [
        'only' => ['store', 'update', 'destroy'],
    ]);
    Route::apiResource('refund-reasons', RefundReasonController::class, [
        'only' => ['store', 'update', 'destroy'],
    ]);
    Route::apiResource('resources', ResourceController::class, [
        'only' => ['update', 'destroy']
    ]);
    // Route::apiResource('coupons', CouponController::class, [
    //     'only' => ['store', 'update', 'destroy'],
    // ]);
    // Route::apiResource('order-status', OrderStatusController::class, [
    //     'only' => ['store', 'update', 'destroy'],
    // ]);
    Route::apiResource('reviews', ReviewController::class, [
        'only' => ['destroy']
    ]);
    Route::apiResource('questions', QuestionController::class, [
        'only' => ['destroy'],
    ]);
    Route::apiResource('feedbacks', FeedbackController::class, [
        'only' => ['update', 'destroy'],
    ]);
    Route::apiResource('abusive_reports', AbusiveReportController::class, [
        'only' => ['index', 'show', 'update', 'destroy'],
    ]);
    Route::post('abusive_reports/accept', [AbusiveReportController::class, 'accept']);
    Route::post('abusive_reports/reject', [AbusiveReportController::class, 'reject']);
    Route::apiResource('settings', SettingsController::class, [
        'only' => ['store'],
    ]);
    Route::apiResource('users', UserController::class);
    Route::apiResource('authors', AuthorController::class, [
        'only' => ['update', 'destroy'],
    ]);
    Route::apiResource('manufacturers', ManufacturerController::class, [
        'only' => ['update', 'destroy'],
    ]);
    Route::post('users/block-user', [UserController::class, 'banUser']);
    Route::post('users/unblock-user', [UserController::class, 'activeUser']);
    Route::apiResource('taxes', TaxController::class);
    Route::apiResource('shippings', ShippingController::class);
    Route::post('approve-shop', [ShopController::class, 'approveShop']);
    Route::post('disapprove-shop', [ShopController::class, 'disApproveShop']);
    Route::post('approve-withdraw', [WithdrawController::class, 'approveWithdraw']);
    Route::post('add-points', [UserController::class, 'addPoints']);
    Route::post('users/make-admin', [UserController::class, 'makeOrRevokeAdmin']);
    Route::apiResource(
        'refunds',
        RefundController::class,
        [
            'only' => ['destroy', 'update'],
        ]
    );
    Route::apiResource('notify-logs', NotifyLogsController::class, [
        'only' => ['destroy'],
    ]);
    // Route::apiResource('faqs', FaqsController::class, [
    //     'only' => ['store', 'update', 'destroy'],
    // ]);
    Route::get('new-shops', [ShopController::class, 'newOrInActiveShops']);
    Route::post('approve-terms-and-conditions', [TermsAndConditionsController::class, 'approveTerm']);
    Route::post('disapprove-terms-and-conditions', [TermsAndConditionsController::class, 'disApproveTerm']);
    Route::get('/admin/list', [UserController::class, 'admins']);
    Route::get('/vendors/list', [UserController::class, 'vendors']);
    Route::get('/customers/list', [UserController::class, 'customers']);
    Route::get('my-staffs', [UserController::class, 'myStaffs']);
    Route::get('all-staffs', [UserController::class, 'allStaffs']);
    Route::resource('refund-policies', RefundPolicyController::class, [
        'only' => ['store', 'update', 'destroy'],
    ]);
    Route::post('approve-coupon', [CouponController::class, 'approveCoupon']);
    Route::post('disapprove-coupon', [CouponController::class, 'disApproveCoupon']);
    // Route::get('requested-products-for-flash-sale', [FlashSaleVendorRequestController::class, 'getRequestedProductsForFlashSale']);
    Route::post('approve-flash-sale-requested-products', [FlashSaleVendorRequestController::class, 'approveFlashSaleProductsRequest']);
    Route::post('disapprove-flash-sale-requested-products', [FlashSaleVendorRequestController::class, 'disapproveFlashSaleProductsRequest']);
    Route::apiResource('vendor-requests-for-flash-sale', FlashSaleVendorRequestController::class, [
        'only' => ['update'],
    ]);
});
