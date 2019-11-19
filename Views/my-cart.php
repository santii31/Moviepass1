<body>
    <header>
        <div class="movie-h account-head">                
            <h3 class="section-title text-s">
                <i class="icon ion-md-cart"></i>
                <?= $title ?>
            </h3>
        </div>
    </header>
        
    <main>
        <div class="container">
            <table border="1">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Ticket quantity</th>
                        <th>Discount</th>							
                        <th>Date</th>		
                        <th>Total</th>												
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($purchases as $purchase): ?>
                        <tr>
                            <td><?= $purchase->getId(); ?></td>        
                            <td><?= $purchase->getTicketQuantity() ?></td>
                            <td>$<?= $purchase->getDiscount(); ?></td>								
                            <td><?= $purchase->getDate(); ?></td>	
                            <td>$<?= $purchase->getTotal(); ?></td>								
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <br>
    </main>