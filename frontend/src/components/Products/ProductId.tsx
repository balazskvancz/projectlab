import { useLocation } from "react-router-dom";

import DisplayProduct from './DisplayProduct';

/**
 * Function komponens, ami kiveszi a queryparamot, majd a egy osztály alapú komponenst pédányosít.
 * @returns {JSX.Element} A lerenderelt elem.
 */
export default function productId(): JSX.Element{
  const search = useLocation().search;
  const productId = new URLSearchParams(search).get('id');

  return (
    <div>
      <DisplayProduct productId={ parseInt(productId!) } />
    </div>
  )
}
