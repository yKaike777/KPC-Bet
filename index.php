<?php 
// ==========================
// CONFIGURAÇÃO DA API
// ==========================
$apiKey = "d0b3dd0a8214e839996d981a6556177c";
$sport = "soccer_brazil_campeonato";
$url = "https://api.the-odds-api.com/v4/sports/$sport/odds";
$url .= "?apiKey=$apiKey&regions=us&markets=h2h,totals&oddsFormat=decimal";


// ==========================
// REQUISIÇÃO C/ cURL
// ==========================
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if(curl_errno($ch)){
    die('Erro ao conectar na API: ' . curl_error($ch));
}

curl_close($ch);

// ==========================
// CONVERTE JSON EM ARRAY
// ==========================
$data = json_decode($response, true);

?>

<?php include 'header.php' ?>
<?php include 'navbar.php' ?>

<div class="container mt-4">
    <h2>Futebol - Série A do Brasil</h2>

    <div class="d-flex flex-row gap-3">
        <div class="flex-grow-1">
            <?php if (!$data || !is_array($data)): ?>
                <p>Erro ao carregar dados da API</p>
            <?php else: ?>
                <?php foreach($data as $partida): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- Nomes dos times -->
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($partida['home_team'] ?? 'Time Casa'); ?> 
                                X 
                                <?php echo htmlspecialchars($partida['away_team'] ?? 'Time Visitante'); ?>
                            </h5>

                            <?php
                            // Verifica se existem bookmakers
                            $bookmaker = $partida['bookmakers'][0] ?? null;

                            if ($bookmaker && is_array($bookmaker) && isset($bookmaker['markets']) && is_array($bookmaker['markets'])):

                                // ==========================
                                // Mercado H2H (vencedor)
                                // ==========================
                                $h2h = null;
                                foreach ($bookmaker['markets'] as $market) {
                                    if (isset($market['key']) && $market['key'] == 'h2h' && isset($market['outcomes']) && is_array($market['outcomes'])) {
                                        $h2h = $market['outcomes'];
                                        break;
                                    }
                                }

                            if ($h2h):

                                $home = null;
                                $away = null;
                                $draw = null;

                                foreach ($h2h as $outcome) {
                                    if (($outcome['name'] ?? '') == ($partida['home_team'] ?? '')) {
                                        $home = $outcome;
                                    } 
                                    elseif (($outcome['name'] ?? '') == ($partida['away_team'] ?? '')) {
                                        $away = $outcome;
                                    } 
                                    else {
                                        $draw = $outcome; // normalmente o empate
                                    }
                                }

                                echo "<div class='mb-2 d-flex justify-content-between'><strong>Resultado:</strong>";
                                echo "<div>";

                                // Casa
                                if ($home) {
                                    echo "<button class='btn btn-success btn-sm me-1' style='width: 60px;'>";
                                    echo "x" . htmlspecialchars($home['price']);
                                    echo "</button>";
                                }

                                // Empate
                                if ($draw) {
                                    echo "<button class='btn btn-secondary btn-sm me-1' style='width: 60px;'>";
                                    echo "x" . htmlspecialchars($draw['price']);
                                    echo "</button>";
                                }

                                // Visitante
                                if ($away) {
                                    echo "<button class='btn btn-danger btn-sm me-1' style='width: 60px;'>";
                                    echo "x" . htmlspecialchars($away['price']);
                                    echo "</button>";
                                }

                                echo "</div></div>";

                            endif;


                                // ==========================
                                // Mercado Totals (Mais/Menos gols)
                                // ==========================
                                $totals = null;
                                foreach ($bookmaker['markets'] as $market) {
                                    if (isset($market['key']) && $market['key'] == 'totals' && isset($market['outcomes']) && is_array($market['outcomes'])) {
                                        $totals = $market['outcomes'];
                                        break;
                                    }
                                }

                                if ($totals):
                                    echo "<div class='d-flex justify-content-between'><strong>Mais/Menos Gols:</strong> ";
                                    echo "<div>";
                                    foreach ($totals as $total):
                                        echo "<button class='btn btn-info btn-sm me-1'>";
                                        echo htmlspecialchars($total['name'] ?? '-')  . " " . htmlspecialchars($total['price'] ?? '-');
                                        echo "</button>";
                                    endforeach;
                                    echo "</div>";
                                    echo "</div>";
                                endif;

                            else:
                                echo "<p>Sem odds disponíveis</p>";
                            endif;
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- IFRAME DO WIDGET -->
        <div>
            <iframe src="https://widget.api-futebol.com.br/render/widget_cb4395a1582f777f" title="API Futebol - Widget" style="border:1px solid #E5E7EB;border-radius:0.375rem;background:transparent;width:100%;height:520px;" loading="lazy" referrerpolicy="unsafe-url" sandbox="allow-scripts allow-forms allow-popups allow-top-navigation-by-user-activation allow-popups-to-escape-sandbox"></iframe>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>
