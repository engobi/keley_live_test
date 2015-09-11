class Produit < ActiveRecord::Base
  attr_accessible :description, :poids, :prix

  has_many :images
  has_and_belongs_to_many :categories
end
