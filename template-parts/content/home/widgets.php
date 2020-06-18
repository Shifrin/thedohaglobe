<?php
/**
 * Template part for displaying some home page widgets
 */
?>

<!-- Widget to show current weather by Forecast7 -->
<div class="weather-details py-3">
    <a class="weatherwidget-io" href="https://forecast7.com/en/25d2951d53/doha/"
       data-label_1="DOHA" data-label_2="WEATHER" data-font="Noto Serif"
       data-icons="Climacons Animated" data-mode="Current" data-theme="gray"
       data-basecolor="rgba(255, 255, 255, 0)" >DOHA WEATHER</a>
    <script>
        !function(d,s,id){
            var js,fjs=d.getElementsByTagName(s)[0];

            if(!d.getElementById(id)){
                js=d.createElement(s);
                js.id=id;
                js.src='https://weatherwidget.io/js/widget.min.js';
                fjs.parentNode.insertBefore(js,fjs);
            }
        }(document,'script','weatherwidget-io-js');
    </script>
</div>

<!-- Widget to show currency rates by TrendingView Widgets -->
<div class="currency-rates my-auto">
    <!-- TradingView Widget BEGIN -->
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <div class="tradingview-widget-copyright">
            <a href="https://www.tradingview.com/symbols/FX_IDC-QARUSD/" rel="noopener" target="_blank">
                <span class="blue-text">QARUSD Rates</span></a> by TradingView
        </div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
            {
                "symbol": "FX_IDC:QARUSD",
                "width": "100%",
                "colorTheme": "dark",
                "isTransparent": true,
                "locale": "en"
            }
        </script>
    </div>

    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/FX_IDC-QARUSD/" rel="noopener" target="_blank"><span class="blue-text">QARUSD Rates</span></a> by TradingView</div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
            {
                "symbol": "FX_IDC:QAREUR",
                "width": "100%",
                "colorTheme": "dark",
                "isTransparent": true,
                "locale": "en"
            }
        </script>
    </div>
    <!-- TradingView Widget END -->
</div>
