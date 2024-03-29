<?php

namespace wnmachado\BrazilianDocumentsTools;

class CNPJ extends DocumentAbstract
{
    /**
     * Check if it is a valid CNPJ number
     *
     * @return bool|string
     */
    public function isValid(): bool
    {
        $isValid = true;
        $c = preg_replace('/\D/', '', $this->value);
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if (strlen($c) != 14 || preg_match("/^{$c[0]}{14}$/", $c) > 0) {
            $isValid = false;
        }

        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $isValid = false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $isValid = false;
        }

        return $isValid;
    }

    /**
     * Format CNPJ
     *
     * @return string
     */
    public function format()
    {
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $this->value);
    }
    /**
     * Get only numbers of CNPJ
     *
     * @return string
     */
    public function getOnlyNumbers()
    {
        return preg_replace("/\D/", "", $this->value);
    }

    /**
     * Hide numbers of CNPJ
     *
     * @return string
     */
    public function hideNumbers()
    {
        $document = $this->getOnlyNumbers();
        return substr($document, 0, 2) . '.###.###/####-' . substr($document, 12, 2);
    }
}
