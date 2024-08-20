<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pedido {{ $commande->ref }}</title>
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}" />
  <style>
    .page-break {
      page-break-after: always;
    }
    @page {
      margin: 0cm 0cm;
      font-family: ui-sans-serif, system-ui, sans-serif,
    }
    body {
      margin: 2cm 2cm;
      font-size: 12px;
    }
    h1, h2, h3, h4, h5, h6, p {
      margin: 0;
    }
  </style>
</head>
<body>
  <main>
    <table style="width: 100%; border-collapse: collapse;">
      <tr>
        <td style="width: 50%;">
          <img src="img/logos/CD-SOLEC_Lema.png" alt="CD-SOLEC" title="CD-SOLEC" style="width: 140px;" />
        </td>
        <td style="width: 50%; text-align: right;">
          <h1>Pedido</h1>
          <h2>{{ $commande->ref }}</h2>
          <h4>Fecha: {{ $commande->date_creation->format('d/m/Y') }}</h4>
        </td>
      </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin: 2em 0;">
      <tr>
        <td style="width: 48%; background-color: #D7D4E1; padding: .5em; vertical-align: top;">
          <h4>CD INVERSIONES TECNOLOGICAS, C.A.</h4>
          <h4>RIF: J504099929</h4>
          <br />
          <p>Teléfonos: (0412)-891.52.99 / (0424)-315.84.30</p>
          <p>Email: ventas@cd-solec.com</p>
          <p>Web: https://cd-solec.com/</p>
        </td>
        <td>&nbsp;</td>
        <td style="width: 48%; background-color: #D7D4E1; padding: .5em; vertical-align: top;">
          <h4>{{ $commande->society->nom }}</h4>
          <h4>RIF: {{ $commande->society->siren }}</h4>
          <br />
          <p>Teléfonos: {{ $commande->society->phone }}</p>
          <p>Email: {{ $commande->society->email }}</p>
        </td>
      </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin: 2em 0;">
      <thead>
        <tr style="background-color: #D7D4E1;">
          <th style="border: 1px solid #000000; padding: .5em; width: 50%; text-align: left;">Producto</th>
          <th style="border: 1px solid #000000; padding: .5em; width: 10%; text-align: center;">Cantidad</th>
          <th style="border: 1px solid #000000; padding: .5em; width: 20%; text-align: right;">Precio</th>
          <th style="border: 1px solid #000000; padding: .5em; width: 20%; text-align: right;">Sub-Total</th>
        </tr>
      </thead>
      <tbody class="w-full flex-1 sm:flex-none bg-white divide-y divide-gray-400 text-sm leading-5">
        @foreach($commande->commande_detail as $item)
          @php
            $price_bs = $item->price * $commande->multicurrency_tx;
            $subtotal_bs = $item->total_ht * $commande->multicurrency_tx;
          @endphp
          <tr>
            <td style="border: 1px solid #000000; padding: .5em;">
              <p><strong>{{ $item->description }}</strong></p>
              <p>Ref: {{ $item->label }}</p>
            </td>
            <td style="border: 1px solid #000000; padding: .5em; text-align: center;">
              {{ $item->qty }}
            </td>
            <td style="border: 1px solid #000000; padding: .5em; text-align: right;">
              <p>Bs {{ number_format($price_bs, 2, ',', '.') }}</p>
              <p>$USD {{ number_format($item->price, 2, ',', '.') }}</p>
            </td>
            <td style="border: 1px solid #000000; padding: .5em; text-align: right;">
              <p>Bs {{ number_format($subtotal_bs, 2, ',', '.') }}</p>
              <p>$USD {{ number_format($item->total_ht, 2, ',', '.') }}</p>
            </td>
          </tr>
        @endforeach
        @php
          $total_bs = $commande->total_ht * $commande->multicurrency_tx;
        @endphp
        <tr style="background-color: #D7D4E1;">
          <td colspan="3" style="border: 1px solid #000000; padding: .5em; text-align: right;">
            SubTotal
          </td>
          <td style="border: 1px solid #000000; padding: .5em; text-align: right;">
            <p>Bs {{ number_format($total_bs, 2, ',', '.') }}</p>
            <p>$USD {{ number_format($commande->total_ht, 2, ',', '.') }}</p>
          </td>
        </tr>
        @php
          $iva_bs = $commande->total_tva * $commande->multicurrency_tx;
        @endphp
        <tr style="background-color: #D7D4E1;">
          <td colspan="3" style="border: 1px solid #000000; padding: .5em; text-align: right;">
            IVA
          </td>
          <td style="border: 1px solid #000000; padding: .5em; text-align: right;">
            <p>Bs {{ number_format($iva_bs, 2, ',', '.') }}</p>
            <p>$USD {{ number_format($commande->total_tva, 2, ',', '.') }}</p>
          </td>
        </tr>
        @php
          $total_bs = $total_bs + $iva_bs;
        @endphp
        <tr style="background-color: #D7D4E1;">
          <td colspan="3" style="border: 1px solid #000000; padding: .5em; text-align: right;">
            <strong>Total</strong>
          </td>
          <td style="border: 1px solid #000000; padding: .5em; text-align: right;">
            <p><strong>Bs {{ number_format($total_bs, 2, ',', '.') }}</strong></p>
            <p><strong>$USD {{ number_format($commande->total_ttc, 2, ',', '.') }}</strong></p>
          </td>
        </tr>
      </tbody>
    </table>
  </main>

  <script type="text/php">
    if (isset($pdf)) {
      $pdf->page_script('
        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
        $pdf->text(60, 800, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
        $pdf->text(440, 800, "https://cd-solec.com/", $font, 10);
      ');
    }
  </script>
</body>
</html>
