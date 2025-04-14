</main>
    <footer class="bg-white shadow-lg mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    <?php 
                    $end_time = microtime(true);
                    $parse_time = round(($end_time - $start_time), 4);
                    echo "Page parsed in {$parse_time} seconds";
                    ?>
                </div>
                <div class="text-sm text-gray-500">
                    Licensed to House | Version <?php echo VERSION; ?>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
