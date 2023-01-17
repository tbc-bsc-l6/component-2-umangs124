import React from "react";
import axios from "axios";
import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

const ProductsByProductType = () => {
  const params = useParams();

  const [products, setProducts] = useState([]);

  useEffect(() => {
    axios
      .get(`http://127.0.0.1:8000/api/products/${params.id}`)
      .then((res) => {
        setProducts(res.data);
      })
      .catch((err) => {
        console.log(err);
      });
  }, [params.id]);
  return (
    <>
      <nav className="navbar navbar-expand-lg bg-light ms-4">
        <a className="navbar-brand" href="http://127.0.0.1:8000/">
          Product Management System
        </a>
      </nav>
      <div className="container mb-4 row g-2 mt-4 mx-auto">
        <h4 className="text-center shadow-lg p-3 bg-body rounded">
          {params.productTypeName} Products
        </h4>
        {products.map((product) => {
          return (
            <div className="col-lg-4 col-md-5" key={product.id}>
              <div
                className="shadow-lg p-3 bg-body rounded"
                style={{ width: "100%", height: "100%" }}
              >
                <div className="text-center">
                  <img
                    className="rounded-circle img-fluid"
                    style={{ width: "150px", height: "150px" }}
                    src={
                      product.image === null
                        ? "http://127.0.0.1:8000/images/no-product-image.jpg"
                        : `http://127.0.0.1:8000/storage/${product.image}`
                    }
                    alt=""
                  />
                </div>
                <div className="card-body">
                  <h5 className="my-3 text-center">{product.name}</h5>
                  {product.stock_id === 1 ? (
                    <i className="text-success d-flex flex-row-reverse">
                      {product.stockName}
                    </i>
                  ) : (
                    <i className="text-danger d-flex flex-row-reverse">
                      {product.stockName}
                    </i>
                  )}
                  <ul className="list-group mb-3">
                    <li className="list-group-item">
                      Price : ${product.price}
                    </li>
                    <li className="list-group-item">
                      Description : {product.description}
                    </li>
                    <li className="list-group-item">
                      Product Type : {product.productType}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          );
        })}
      </div>
    </>
  );
};

export default ProductsByProductType;
