

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="/custom/include/js/cdn-tailwindcss-3.4.3.js"></script>
    <style>
        {literal}
            html {
                font-size: 16px;
            }
        {/literal}
    </style>
</head>

<body>
    <div class="flex h-screen">
        <div class="w-full lg:w-1/2 2xl:w-1/3 h-full bg-white shadow-md rounded border-r border-white-300">
            <div class="flex flex-col h-full">
                <div class="flex-1 text-center mt-12 md:mt-18 lg:mt-36 w-full">
                    <img src="/custom/themes/default/images/company_logo.png"
                         alt="Company Logo"
                         class="m-auto"
                         style="height: 180px;">
                </div>

                <div class="flex-1 px-4 m-2">
                    <div class="px-8 pt-6 pb-8 mb-2 align-center w-full">
                        <div class="flex flex-row md:flex-col lg:flex-row items-center justify-between">
                            <div class="w-full">
                                <p class="text-center text-2xl mb-5 text-gray-500 font-bold">Welcome to <span class="text-sky-500">Empower CRM</span></p>

                                <a href="{$LOGIN_URL}" class="text-center text-base md:text-lg block bg-transparent hover:bg-sky-500 text-gray-500 font-semibold hover:text-white py-2 px-4 border border-gray-500 hover:border-transparent rounded-full">
                                    Login via Single-Sign On
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1 text-center px-4 py-4 m-2">
                    <p>© Supercharged by <span class="text-sky-500">SuiteCRM</span> © Powered By <span class="text-sky-500">SugarCRM</span></p>
                </div>
            </div>
        </div>

        <div class="invisible lg:visible lg:w-1/2 lg:w-full">
            <div class="bg-fixed h-full"
                 style="
                    background: url('/custom/themes/SuiteP/images/login-bg.jpg') no-repeat;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: cover;
                ">
            </div>
        </div>
    </div>
</body>