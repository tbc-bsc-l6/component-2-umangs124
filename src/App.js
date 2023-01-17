import { Route, Routes } from "react-router-dom";
import ProductsByProductType from "./components/ProductsByProductType";
function App() {
  return (
    <Routes>
      <Route path="/products/:id/:productTypeName" element={<ProductsByProductType />} />
    </Routes>
  );
}

export default App;
